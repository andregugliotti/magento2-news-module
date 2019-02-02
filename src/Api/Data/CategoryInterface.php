<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Api\Data;

/**
 * Interface CategoryInterface
 *
 * Gugliotti News Category Repository Interface.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.1.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Api
 * @api
 */
interface CategoryInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const CATEGORY_ID = 'category_id';
    const CODE = 'code';
    const LABEL = 'label';
    const STATUS = 'status';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    /**#@- */

    /**
     * Get ID
     * @return int
     */
    public function getId();

    /**
     * Get code
     * @return string
     */
    public function getCode();

    /**
     * Set code
     * @param string $code
     * @return mixed
     */
    public function setCode($code);

    /**
     * Get label
     * @return string
     */
    public function getLabel();

    /**
     * Set label
     * @param string $label
     * @return mixed
     */
    public function setLabel($label);

    /**
     * Get status
     * @return boolean
     */
    public function getStatus();

    /**
     * Set status
     * @param string $status
     * @return mixed
     */
    public function setStatus($status);

    /**
     * Get created_at
     * @return string
     */
    public function getCreatedAt();

    /**
     * Get updated_at
     * @return string
     */
    public function getUpdatedAt();

    /**
     * Set updated_at
     * @param string $updatedAt
     * @return mixed
     */
    public function setUpdatedAt($updatedAt);
}
