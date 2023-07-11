<?php

class Collaborateur extends \Phalcon\Mvc\Model
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
     * @Column(column="prenom_nom", type="string", length=255, nullable=true)
     */
    protected $prenom_nom;

    /**
     *
     * @var string
     * @Column(column="niveau_competence", type="string", length='1','2','3', nullable=true)
     */
    protected $niveau_competence;

    /**
     *
     * @var integer
     * @Column(column="prime_embauche", type="integer", nullable=true)
     */
    protected $prime_embauche;

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
     * Method to set the value of field prenom_nom
     *
     * @param string $prenom_nom
     * @return $this
     */
    public function setPrenomNom($prenom_nom)
    {
        $this->prenom_nom = $prenom_nom;

        return $this;
    }

    /**
     * Method to set the value of field niveau_competence
     *
     * @param string $niveau_competence
     * @return $this
     */
    public function setNiveauCompetence($niveau_competence)
    {
        $this->niveau_competence = $niveau_competence;

        return $this;
    }

    /**
     * Method to set the value of field prime_embauche
     *
     * @param integer $prime_embauche
     * @return $this
     */
    public function setPrimeEmbauche($prime_embauche)
    {
        $this->prime_embauche = $prime_embauche;

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
     * Returns the value of field prenom_nom
     *
     * @return string
     */
    public function getPrenomNom()
    {
        return $this->prenom_nom;
    }

    /**
     * Returns the value of field niveau_competence
     *
     * @return string
     */
    public function getNiveauCompetence()
    {
        return $this->niveau_competence;
    }

    /**
     * Returns the value of field prime_embauche
     *
     * @return integer
     */
    public function getPrimeEmbauche()
    {
        return $this->prime_embauche;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("ECF7");
        $this->setSource("collaborateur");
        $this->hasMany('id', 'Chefdeprojet', 'id_collaborateur', ['alias' => 'Chefdeprojet']);
        $this->hasMany('id', 'Developpeur', 'id_collaborateur', ['alias' => 'Developpeur']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Collaborateur[]|Collaborateur|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Collaborateur|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
