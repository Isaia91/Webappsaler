<?php

namespace Test1\Models;

class Equipe extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(column="id", type="integer", nullable=false)
     */
    protected $id;

    /**
     *
     * @var integer
     * @Column(column="chefDeProjet_id", type="integer", nullable=false)
     */
    protected $chefDeProjet_id;

    /**
     *
     * @var string
     * @Column(column="nom", type="string", length=50, nullable=false)
     */
    protected $nom;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field chefDeProjet_id
     *
     * @param integer $chefDeProjet_id
     * @return $this
     */
    public function setChefDeProjetId($chefDeProjet_id)
    {
        $this->chefDeProjet_id = $chefDeProjet_id;

        return $this;
    }

    /**
     * Method to set the value of field nom
     *
     * @param string $nom
     * @return $this
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field chefDeProjet_id
     *
     * @return integer
     */
    public function getChefDeProjetId()
    {
        return $this->chefDeProjet_id;
    }

    /**
     * Returns the value of field nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("ECF7");
        $this->setSource("equipe");
        $this->hasMany('id', 'Test1\Models\EquipeMembres', 'id_equipe', ['alias' => 'EquipeMembres']);
        $this->belongsTo('chefDeProjet_id', 'Test1\Models\ChefDeProjet', 'id', ['alias' => 'Chefdeprojet']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Equipe[]|Equipe|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Equipe|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
