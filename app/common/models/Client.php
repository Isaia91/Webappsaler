<?php

class Client extends \Phalcon\Mvc\Model
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
     * @var string
     * @Column(column="raison_social", type="string", length=50, nullable=true)
     */
    protected $raison_social;

    /**
     *
     * @var string
     * @Column(column="ridet", type="string", length=10, nullable=true)
     */
    protected $ridet;

    /**
     *
     * @var integer
     * @Column(column="ssi2", type="integer", length=1, nullable=true)
     */
    protected $ssi2;

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
     * Method to set the value of field raison_social
     *
     * @param string $raison_social
     * @return $this
     */
    public function setRaisonSocial($raison_social)
    {
        $this->raison_social = $raison_social;

        return $this;
    }

    /**
     * Method to set the value of field ridet
     *
     * @param string $ridet
     * @return $this
     */
    public function setRidet($ridet)
    {
        $this->ridet = $ridet;

        return $this;
    }

    /**
     * Method to set the value of field ssi2
     *
     * @param integer $ssi2
     * @return $this
     */
    public function setSsi2($ssi2)
    {
        $this->ssi2 = $ssi2;

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
     * Returns the value of field raison_social
     *
     * @return string
     */
    public function getRaisonSocial()
    {
        return $this->raison_social;
    }

    /**
     * Returns the value of field ridet
     *
     * @return string
     */
    public function getRidet()
    {
        return $this->ridet;
    }

    /**
     * Returns the value of field ssi2
     *
     * @return integer
     */
    public function getSsi2()
    {
        return $this->ssi2;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("ECF7");
        $this->setSource("client");
        $this->hasMany('id', 'Commande', 'id_client', ['alias' => 'Commande']);
        $this->hasMany('id', 'Projet', 'id_client', ['alias' => 'Projet']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Client[]|Client|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Client|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
