<?php

namespace Andresdevr\LaravelApprovals\Traits;

use Andresdevr\LaravelApprovals\Exceptions\ApprovalsModeNotSupported;
use Andresdevr\LaravelApprovals\Exceptions\ColumnDataTypeNotSupported;
use Andresdevr\LaravelApprovals\Exceptions\ModelNotImplementsMethod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

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
     * Get the column change data
     * 
     * @param bool $inArray
     * @return \Illuminate\Support\Collection|array
     */
    public function getPendingChanges($inArray = false)
    {
        $pendingChanges = $this->getPendingChangesData();
        
        if(is_null($pendingChanges))
        {
            $pendingChanges = '{}';
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
     * @return string|array|\Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Collection mixed
     */
    private function getPendingChangesData()
    {
        switch(config('approvals.mode')) {
            case 'database':
                if(method_exists(self::class, 'pendingChanges'))
                    return $this->pendingChanges()->get();
                else        
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
            Config::get('approvals.events.model_request_changes')::dispatch($this);
        }
        
        return $this->save();
    }

    /**
     * save the data 
     * 
     * @return bool
     */
    private function savePendingChanges()
    {
        
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
     * 
     * @param string attribute
     * @param bool $quietly
     * @return bool
     */
    public function approveChange(string $attribute, bool $quietly = false)
    {


        if(! $quietly)
        {
            Config::get('approvals.events.model_was_approved');
        }
    }

    /**
     * approve change without fire any event
     * 
     * @param string $attribute
     * @return bool
     */
    public function approveChangeQuietly(string $attribute)
    {
        return $this->approveChange($attribute, true);
    }

    /**
     * deny a change without modify this model denied
     * 
     * @param string $attribute
     * @param string|mixed $reasonForDenial
     * @param bool $quietly
     * @return bool
     */
    public function denyChange(string $attribute, $reasonForDenial = null, bool $quietly = false)
    {



        if(! $quietly)
        {
            Config::get('approvals.events.model_was_denied')::dispatch($this);
        }
    }

    /**
     * deny a change without changed without fire any event
     * 
     * @param string $attribute
     * @param string|mixed $reasonForDenial
     * @return bool
     */
    public function denyChangeQuietly(string $attribute, $reasonForDenial = null)
    {
        return $this->denyChange($attribute, $reasonForDenial);
    }
}
