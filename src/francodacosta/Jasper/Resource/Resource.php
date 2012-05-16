<?php
namespace francodacosta\Jasper\Resource;
/**
 * Represents a basic server resource.
 * This class can be extended to provide specific functionality per resource type
 *
 * @author Nuno Costa <nuno@francodacosta.com>
 *
 */
class Resource
{
    private $id;
    private $label;
    private $description;
    private $uri;
    private $type;
    private $creationDate;
    private $isNew;
    private $properties = array();

    private $attachments = array();

    /**
     * Populates the resource from a xml document
     *
     * @param \SimpleXMLElement $xml the response from jasper server
     * @param Resource $obj the object to attach the processed response
     *
     * @return none;
     */
    public function fromJasperListResponse(\SimpleXMLElement $xml, Resource $obj = null)
    {

        $response = $xml->resourceDescriptor ? $xml->resourceDescriptor : $xml;
        $obj = null === $obj ? $this : $obj;


        $obj->id = (string) $response->attributes()->name;
        $obj->type = (string) $response->attributes()->wsType;
        $obj->uri = (string) $response->attributes()->uriString;
        $obj->isNew = (string) $response->attributes()->isNew;
        $obj->label = (string) @$response->label;
        $obj->description = (string) @$response->description;
        $obj->creationDate = (string) @$response->creationDate;

        $this->processProperties($response, $obj);

        foreach ($response->resourceDescriptor as $resource) {
            $resourceObj = new Resource();
            $resourceObj->fromJasperListResponse($resource);
            $this->attachments[] = $resourceObj;
        }

    }

    /**
     * Proceesses the response node to get some properties.
     *
     * @param \SimpleXMLElement $response the response from jasper server
     * @param Resource $obj the object to attach the processed response
     *
     * @return none
     */
    private function processProperties(\SimpleXMLElement $response, Resource $obj)
    {
        foreach ($response->resourceProperty as $property) {
            $name = strtoupper($property->attributes()->name);
            $value = (string) $property->value;

            $obj->properties[$name] = $value;
        }
    }



    /**
     * Returns true if the $name property exists.
     * if $name is null then returns true if we have any property
     *
     * @param string|null $name
     *
     * @return boolean
     */
    public function hasProperty($name = null)
    {
        $name = strtoupper($name);

        return null === $name ? count($this->properties) > 0
                : array_key_exists($name, $this->properties);
    }

    /**
     * Return the value of $name property.
     * if $name is null returns all properties
     *
     * @param string|null $name
     *
     * @return string|string[]
     */
    public function getProperties($name = null)
    {
        $name = strtoupper($name);

        return null === $name ? $this->properties : $this->properties[$name];
    }

    /**
     * @return string the id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string the label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * sets the resource creation date.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the resource type.
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * gets the resource creation date.
     *
     * @return timestamp
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * sets the resource creation date.
     *
     * @param timestamp $creationDate
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * gets the value of IsNew property.
     *
     * @return boolean
     */
    public function getIsNew()
    {
        return $this->isNew;
    }

    /**
     * sets the value of IsNew property.
     *
     * @param boolean $isNew
     */
    public function setIsNew($isNew)
    {
        $this->isNew = $isNew;
    }

    /**
     * String representation of the object.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf("label: %s type: %s uri: %s created at: %s", $this->getLabel(), $this->getType(), $this->getUri(), $this->getCreationDate());
    }

    /**
     * Sets the report attachments.
     * typicaly he attachements are returned with the report request
     * the report itself will be an attachment of the reportunit
     *
     * @param array $attachments
     */
    protected function setAttachments(array $attachments)
    {
        $this->attachments = $attachments;
    }

    /**
     * do we have attachments?.
     * returns true if the report as the $name attachment or if not specified returns true if we have any attachemnt
     *
     * @param string $name
     *
     * @return string|string[]
     */
    public function hasAttachments($name = null)
    {
        return is_null($name) ?  count($this->attachments) > 0 : array_key_exists($name, $this->attachments);

    }

    /**
     * gets one or all attachments.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getAttachments($name = null)
    {
        return is_null($name) ? $this->attachments : $this->attachments[$name];
    }

}
