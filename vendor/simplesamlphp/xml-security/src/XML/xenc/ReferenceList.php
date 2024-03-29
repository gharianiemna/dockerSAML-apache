<?php

declare(strict_types=1);

namespace SimpleSAML\XMLSecurity\XML\xenc;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XMLSecurity\Exception\InvalidArgumentException;

use function array_merge;

/**
 * A class containing a list of references to either encrypted data or encryption keys.
 *
 * @package simplesamlphp/xml-security
 */
class ReferenceList extends AbstractXencElement
{
    /** @var \SimpleSAML\XMLSecurity\XML\xenc\DataReference[] */
    protected array $dataReferences;

    /** @var \SimpleSAML\XMLSecurity\XML\xenc\KeyReference[] */
    protected array $keyreferences;


    /**
     * ReferenceList constructor.
     *
     * @param \SimpleSAML\XMLSecurity\XML\xenc\DataReference[] $dataReferences
     * @param \SimpleSAML\XMLSecurity\XML\xenc\KeyReference[] $keyreferences
     */
    public function __construct(array $dataReferences, array $keyreferences = [])
    {
        $this->setDataReferences($dataReferences);
        $this->setKeyReferences($keyreferences);
        Assert::minCount(
            array_merge($this->dataReferences, $this->keyreferences),
            1,
            'At least one <xenc:DataReference> or <xenc:KeyReference> element required in <xenc:ReferenceList>.',
            MissingElementException::class,
        );
    }


    /**
     * Get the list of DataReference objects.
     *
     * @return \SimpleSAML\XMLSecurity\XML\xenc\DataReference[]
     */
    public function getDataReferences(): array
    {
        return $this->dataReferences;
    }


    /**
     * @param \SimpleSAML\XMLSecurity\XML\xenc\DataReference[] $dataReferences
     */
    protected function setDataReferences(array $dataReferences): void
    {
        Assert::allIsInstanceOf(
            $dataReferences,
            DataReference::class,
            'All data references must be an instance of <xenc:DataReference>.',
            InvalidArgumentException::class,
        );

        $this->dataReferences = $dataReferences;
    }


    /**
     * Get the list of KeyReference objects.
     *
     * @return \SimpleSAML\XMLSecurity\XML\xenc\KeyReference[]
     */
    public function getKeyReferences(): array
    {
        return $this->keyreferences;
    }


    /**
     * @param \SimpleSAML\XMLSecurity\XML\xenc\KeyReference[] $keyReferences
     */
    protected function setKeyReferences(array $keyReferences): void
    {
        Assert::allIsInstanceOf(
            $keyReferences,
            KeyReference::class,
            'All key references must be an instance of <xenc:KeyReference>.',
            InvalidArgumentException::class,
        );

        $this->keyreferences = $keyReferences;
    }


    /**
     * @inheritDoc
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): self
    {
        Assert::same($xml->localName, 'ReferenceList', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, ReferenceList::NS, InvalidDOMElementException::class);

        $dataReferences = DataReference::getChildrenOfClass($xml);
        $keyReferences = KeyReference::getChildrenOfClass($xml);

        return new self($dataReferences, $keyReferences);
    }


    /**
     * @inheritDoc
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        foreach ($this->dataReferences as $dref) {
            $dref->toXML($e);
        }

        foreach ($this->keyreferences as $kref) {
            $kref->toXML($e);
        }

        return $e;
    }
}
