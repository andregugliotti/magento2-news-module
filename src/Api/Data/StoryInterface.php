<?php
/**
 * Gugliotti News
 */
namespace Gugliotti\News\Api\Data;

/**
 * Interface StoryInterface
 *
 * Gugliotti News Story Repository Interface.
 * @author Andre Gugliotti <andre@gugliotti.com.br>
 * @version 0.2.0
 * @license GNU General Public License, version 3
 * @package Gugliotti\News\Api
 * @api
 */
interface StoryInterface
{
    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const STORY_ID = 'story_id';
    const TITLE = 'title';
    const THUMBNAIL_PATH = 'thumbnail_path';
    const CONTENT = 'content';
    const STATUS = 'status';
    const CATEGORY_ID = 'category_id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    /**#@- */

    /**
     * Get ID
     * @return int
     */
    function getId();

    /**
     * getTitle
     * @return mixed
     */
    function getTitle();

    /**
     * setTitle
     * @param string $title
     * @return $this|mixed
     */
    function setTitle($title);

    /**
     * getThumbnailPath
     * @return mixed|string
     */
    function getThumbnailPath();

    /**
     * setThumbnailPath
     * @param string $thumbnailPath
     * @return $this|mixed
     */
    function setThumbnailPath($thumbnailPath);

    /**
     * getContent
     * @return mixed|string
     */
    function getContent();

    /**
     * setContent
     * @param string $content
     * @return $this|mixed
     */
    function setContent($content);

    /**
     * getStatus
     * @return mixed|string
     */
    function getStatus();

    /**
     * setStatus
     * @param string $status
     * @return $this|mixed
     */
    function setStatus($status);

    /**
     * getCategoryId
     * @return mixed
     */
    function getCategoryId();

    /**
     * setCategoryId
     * @param $categoryId
     * @return $this
     */
    function setCategoryId($categoryId);

    /**
     * Get created_at
     * @return string
     */
    function getCreatedAt();

    /**
     * Get updated_at
     * @return string
     */
    function getUpdatedAt();

    /**
     * Set updated_at
     * @param string $updatedAt
     * @return mixed
     */
    function setUpdatedAt($updatedAt);
}
