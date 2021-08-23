<?php

namespace Andresdevr\LaravelApprovals\Traits;


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
        if($this->{$this->getApprovalKey()})
        {

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
     */
    public function addToPending(bool $quietly = false)
    {

    }

    public function addToPendingQuietly()
    {
        return $this->addToPending(true);
    }

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
