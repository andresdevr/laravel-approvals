<?php

namespace Andresdevr\LaravelApprovals\Traits;

use Andresdevr\LaravelApprovals\Exceptions\ApprovalsModeNotSupported;
use Andresdevr\LaravelApprovals\Exceptions\ColumnDataTypeNotSupported;
use Andresdevr\LaravelApprovals\Exceptions\ModelNotImplementsMethod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

/**
 * 
 */
trait HasApprovals
{
    /**
     * The column/key to save the pending changes
     * 
     * @var string
     */
    protected $approvalKey;

    /** 
     * The approval timestamp format
     * 
     * @var string
    */
    protected $approvalDateFormat;

    /**
     * The approval strict model
     * 
     * @var bool
     */
    protected $approvalStrict;

    /**
     * Return the approval key to save pending changes
     * 
     * @return string|mixed
     */
    public function getApprovalKey()
    {
        return (isset($this->approvalKey) && !is_null($this->approvalKey)) ? 
            $this->approvalKey : 
            config('approvals.key');
    }

    /**
     * Get the column change data
     * 
     * @return array|\Illuminate\Support\Collection
     */
    public function getPendingChanges($inArray = false)
    {
        $pendingChanges = $this->getPendingChanges();

        if(is_null($pendingChanges))
        {
            $pendingChanges = '';
        }
        if(is_string($pendingChanges))
        {
            if(isJson($pendingChanges))
            {
                $pendingChanges = json_decode($pendingChanges, true);
            }
            else
            {
            }
        }
        if(is_array($pendingChanges))
        {
            if($inArray)
            {
                return $pendingChanges;
            }
            else
            {
                $pendingChanges = Collection::make($pendingChanges);
            }
        }
        if($pendingChanges instanceof Collection)
        {
            return $pendingChanges;
        }

        throw new ColumnDataTypeNotSupported();
    }

    /**
     * check the config to return the data
     * 
     * @return string|array|mixed
     */
    private function getPendingChangesData()
    {
        switch(config('approvals.mode')) {
            case 'database':
                return method_exists(self::class, 'pendingChanges') ? 
                    $this->pendingChanges()->get() :
                    throw new ModelNotImplementsMethod();
                break;
            case 'model':
                return $this->{$this->getApprovalKey()};
                break;
            case 'cache':
                return Cache::tags(config('approvals.cache_tag'))
                            ->get($this->getApprovalKey() . $this->{$this->getKeyName()});
                break;
            default:
                throw new ApprovalsModeNotSupported();
        }
    }

    /**
     * set the approval key to save pending changes
     * 
     * @return self
     */
    public function setApprovalKey(string $key) : self
    {
        $this->approvalKey = $key;

        return $this;
    }

    /**
     * set the approval timestamp format
     * 
     * @param string $format
     * @return self
     */
    public function setApprovalTimestamp($format)
    {
        $this->approvalDateFormat = $format;

        return $this;
    }

    /**
     * deactivate the strict mode
     * 
     * @return self
     */
    public function notStrict()
    {
        $this->approvalStrict = false;

        return $this;
    }

    /**
     * save the pending changes into the column
     * 
     * @param bool $quietly
     * @return bool
     */
    public function addToPending(bool $quietly = false)
    {
        $pendingChanges = $this->getPendingChanges();
        
        foreach($this->getDirty() as $attribute => $value)
        {
            $pendingChanges[$attribute] = collect([
                'user_id' => Auth::check() ? Auth::id() : null,
                'change' => $value,
                'reason_for_denial' => '',
                'approved' => 0
            ]);
            
            $this->attributes[$attribute] = $this->getRawOriginal($attribute);
        }

        $this->savePendingChanges($pendingChanges);

        if(! $quietly)
        {
            config('approvals.events.model_request_changes')::dispatch($this);
        }
        
        return $this->save();
    }

    /**
     * save the pending changes into column without fire any event
     * 
     * @return bool
     */
    public function addToPendingQuietly()
    {
        return $this->addToPending(true);
    }

    /**
     * approve and save change approved
     */
    public function approveChange(string $attribute, $quietly = false)
    {

    }

    public function approveChangeQuietly(string $attribute)
    {
        return $this->approveChange($attribute, true);
    }

    public function denyChange(string $attribute, $reasonForDenial = null, $quietly = false)
    {

    }

    public function denyChangeQuietly(string $attribute, $reasonForDenial = null)
    {
        return $this->denyChange($attribute, $reasonForDenial);
    }
}
