<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Modelo Entity
 *
 * @property int $id
 * @property int $marca_id
 * @property string $nombre
 *
 * @property \App\Model\Entity\Marca $marca
 * @property \App\Model\Entity\Vehiculo[] $vehiculos
 */
class Modelo extends Entity
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
        'marca_id' => true,
        'nombre' => true,
        'marca' => true,
        'vehiculos' => true,
    ];
}
