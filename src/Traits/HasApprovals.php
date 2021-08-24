<?php

namespace Andresdevr\LaravelApprovals\Traits;

use Andresdevr\LaravelApprovals\Exceptions\ApprovalsModeNotSupported;
use Andresdevr\LaravelApprovals\Exceptions\ColumnDataTypeNotSupported;
use Illuminate\Support\Collection;
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
                return $this->{$this->getApprovalKey()};
                break;
            case 'cache':
                return Cache::get($this->getApprovalKey() . $this->{$this->getKeyName()});
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
     * save the pending changes into the column
     * 
     * @param bool $quietly
     * @return bool
     */
    public function addToPending(bool $quietly = false)
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
