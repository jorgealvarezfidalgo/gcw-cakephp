<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Post Entity.
 *
 * @property int $id
 * @property int $category_id
 * @property \App\Model\Entity\Category $category
 * @property string $title
 * @property string $excerpt
 * @property string $content
 * @property \Cake\I18n\Time $published_date
 * @property \Cake\I18n\Time $published_time
 * @property bool $visible
 * @property bool $featured
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \App\Model\Entity\Tag[] $tags
 */
class Post extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'id' => false,
        '*' => true
    ];

    /**
     * Hidden fields to not show in JSON responses
     *
     * @var array
     */
    protected $_hidden = [
        'id',
        'category_id'
    ];
}
