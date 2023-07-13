<?php

namespace Test1\Models;

class Commande extends \Phalcon\Mvc\Model
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
     * @Column(column="id_application", type="integer", nullable=true)
     */
    protected $id_application;

    /**
     *
     * @var integer
     * @Column(column="id_module", type="integer", nullable=true)
     */
    protected $id_module;

    /**
     *
     * @var integer
     * @Column(column="id_composant", type="integer", nullable=true)
     */
    protected $id_composant;

    /**
     *
     * @var integer
     * @Column(column="id_client", type="integer", nullable=false)
     */
    protected $id_client;

    /**
     *
     * @var integer
     * @Column(column="id_developpement", type="integer", nullable=false)
     */
    protected $id_developpement;

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
     * Method to set the value of field id_application
     *
     * @param integer $id_application
     * @return $this
     */
    public function setIdApplication($id_application)
    {
        $this->id_application = $id_application;

        return $this;
    }

    /**
     * Method to set the value of field id_module
     *
     * @param integer $id_module
     * @return $this
     */
    public function setIdModule($id_module)
    {
        $this->id_module = $id_module;

        return $this;
    }

    /**
     * Method to set the value of field id_composant
     *
     * @param integer $id_composant
     * @return $this
     */
    public function setIdComposant($id_composant)
    {
        $this->id_composant = $id_composant;

        return $this;
    }

    /**
     * Method to set the value of field id_client
     *
     * @param integer $id_client
     * @return $this
     */
    public function setIdClient($id_client)
    {
        $this->id_client = $id_client;

        return $this;
    }

    /**
     * Method to set the value of field id_developpement
     *
     * @param integer $id_developpement
     * @return $this
     */
    public function setIdDeveloppement($id_developpement)
    {
        $this->id_developpement = $id_developpement;

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
     * Returns the value of field id_application
     *
     * @return integer
     */
    public function getIdApplication()
    {
        return $this->id_application;
    }

    /**
     * Returns the value of field id_module
     *
     * @return integer
     */
    public function getIdModule()
    {
        return $this->id_module;
    }

    /**
     * Returns the value of field id_composant
     *
     * @return integer
     */
    public function getIdComposant()
    {
        return $this->id_composant;
    }

    /**
     * Returns the value of field id_client
     *
     * @return integer
     */
    public function getIdClient()
    {
        return $this->id_client;
    }

    /**
     * Returns the value of field id_developpement
     *
     * @return integer
     */
    public function getIdDeveloppement()
    {
        return $this->id_developpement;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("ECF7");
        $this->setSource("commande");
        $this->belongsTo('id_application', 'Test1\Models\Application', 'id', ['alias' => 'Application']);
        $this->belongsTo('id_client', 'Test1\Models\Client', 'id', ['alias' => 'Client']);
        $this->belongsTo('id_composant', 'Test1\Models\Composant', 'id', ['alias' => 'Composant']);
        $this->belongsTo('id_module', 'Test1\Models\Module', 'id', ['alias' => 'Module']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Commande[]|Commande|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Commande|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
