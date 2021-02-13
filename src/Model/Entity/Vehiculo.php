<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Vehiculo Entity
 *
 * @property int $id
 * @property int $modelo_id
 * @property int $combustible_id
 * @property int $anno
 * @property float $precio
 * @property int $kms
 *
 * @property \App\Model\Entity\Modelo $modelo
 * @property \App\Model\Entity\Combustible $combustible
 * @property \App\Model\Entity\Contacto[] $contactos
 */
class Vehiculo extends Entity
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
        'modelo_id' => true,
        'combustible_id' => true,
        'anno' => true,
        'precio' => true,
        'kms' => true,
        'modelo' => true,
        'combustible' => true,
        'contactos' => true,
    ];
}
