<?php

declare(strict_types=1);

namespace SimpleSAML\XMLSecurity\XML\xenc;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\MissingElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Exception\TooManyElementsException;
use SimpleSAML\XMLSecurity\Exception\InvalidArgumentException;
use SimpleSAML\XMLSecurity\XML\ds\KeyInfo;

use function count;

/**
 * Abstract class representing encrypted data.
 *
 * Note: <xenc:EncryptionProperties> elements are not supported.
 *
 * @package simplesamlphp/xml-security
 */
abstract class AbstractEncryptedType extends AbstractXencElement
{
    /** @var \SimpleSAML\XMLSecurity\XML\xenc\CipherData */
    protected CipherData $cipherData;

    /** @var string|null */
    protected ?string $encoding;

    /** @var \SimpleSAML\XMLSecurity\XML\xenc\EncryptionMethod|null */
    protected ?EncryptionMethod $encryptionMethod;

    /** @var string|null */
    protected ?string $id;

    /** @var \SimpleSAML\XMLSecurity\XML\ds\KeyInfo|null */
    protected ?KeyInfo $keyInfo;

    /** @var string|null */
    protected ?string $mimeType;

    /** @var string|null */
    protected ?string $type;


    /**
     * EncryptedData constructor.
     *
     * @param \SimpleSAML\XMLSecurity\XML\xenc\CipherData $cipherData The CipherData object of this EncryptedData.
     * @param string|null $id The Id attribute of this object. Optional.
     * @param string|null $type The Type attribute of this object. Optional.
     * @param string|null $mimeType The MimeType attribute of this object. Optional.
     * @param string|null $encoding The Encoding attribute of this object. Optional.
     * @param \SimpleSAML\XMLSecurity\XML\xenc\EncryptionMethod|null $encryptionMethod
     *   The EncryptionMethod object of this EncryptedData. Optional.
     * @param \SimpleSAML\XMLSecurity\XML\ds\KeyInfo|null $keyInfo The KeyInfo object of this EncryptedData. Optional.
     */
    public function __construct(
        CipherData $cipherData,
        ?string $id = null,
        ?string $type = null,
        ?string $mimeType = null,
        ?string $encoding = null,
        ?EncryptionMethod $encryptionMethod = null,
        ?KeyInfo $keyInfo = null
    ) {
        $this->setCipherData($cipherData);
        $this->setEncoding($encoding);
        $this->setID($id);
        $this->setMimeType($mimeType);
        $this->setType($type);
        $this->setEncryptionMethod($encryptionMethod);
        $this->setKeyInfo($keyInfo);
    }


    /**
     * Get the CipherData object.
     *
     * @return \SimpleSAML\XMLSecurity\XML\xenc\CipherData
     */
    public function getCipherData(): CipherData
    {
        return $this->cipherData;
    }


    /**
     * @param \SimpleSAML\XMLSecurity\XML\xenc\CipherData $cipherData
     */
    protected function setCipherData(CipherData $cipherData): void
    {
        $this->cipherData = $cipherData;
    }


    /**
     * Get the value of the Encoding attribute.
     *
     * @return string|null
     */
    public function getEncoding(): ?string
    {
        return $this->encoding;
    }


    /**
     * @param string|null $encoding
     */
    protected function setEncoding(?string $encoding): void
    {
        Assert::nullOrValidURI($encoding, SchemaViolationException::class); // Covers the empty string
        $this->encoding = $encoding;
    }


    /**
     * Get the EncryptionMethod object.
     *
     * @return \SimpleSAML\XMLSecurity\XML\xenc\EncryptionMethod|null
     */
    public function getEncryptionMethod(): ?EncryptionMethod
    {
        return $this->encryptionMethod;
    }


    /**
     * @param \SimpleSAML\XMLSecurity\XML\xenc\EncryptionMethod|null $encryptionMethod
     */
    protected function setEncryptionMethod(?EncryptionMethod $encryptionMethod): void
    {
        $this->encryptionMethod = $encryptionMethod;
    }


    /**
     * Get the value of the Id attribute.
     *
     * @return string
     */
    public function getID(): ?string
    {
        return $this->id;
    }


    /**
     * @param string|null $id
     */
    protected function setID(?string $id): void
    {
        Assert::nullOrValidNCName($id, SchemaViolationException::class); // Covers the empty string
        $this->id = $id;
    }


    /**
     * Get the KeyInfo object.
     *
     * @return \SimpleSAML\XMLSecurity\XML\ds\KeyInfo|null
     */
    public function getKeyInfo(): ?KeyInfo
    {
        return $this->keyInfo;
    }


    /**
     * @param \SimpleSAML\XMLSecurity\XML\ds\KeyInfo|null $keyInfo
     */
    protected function setKeyInfo(?KeyInfo $keyInfo): void
    {
        $this->keyInfo = $keyInfo;
    }


    /**
     * Get the value of the MimeType attribute.
     *
     * @return string
     */
    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }


    /**
     * @param string|null $mimeType
     */
    protected function setMimeType(?string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }


    /**
     * Get the value of the Type attribute.
     *
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }


    /**
     * @param string|null $type
     */
    protected function setType(?string $type): void
    {
        Assert::nullOrValidURI($type, SchemaViolationException::class); // Covers the empty string
        $this->type = $type;
    }


    /**
     * @inheritDoc
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   If the qualified name of the supplied element is wrong
     * @throws \SimpleSAML\XML\Exception\MissingElementException
     *   If one of the mandatory child-elements is missing
     * @throws \SimpleSAML\XML\Exception\TooManyElementsException
     *   If too many child-elements of a type are specified
     */
    public static function fromXML(DOMElement $xml): self
    {
        Assert::same($xml->localName, 'EncryptedData', InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, EncryptedData::NS, InvalidDOMElementException::class);

        $cipherData = CipherData::getChildrenOfClass($xml);
        Assert::minCount(
            $cipherData,
            1,
            'At least one CipherData element found in <xenc:EncryptedData>.',
            MissingElementException::class,
        );
        Assert::maxCount(
            $cipherData,
            1,
            'No or more than one CipherData element found in <xenc:EncryptedData>.',
            TooManyElementsException::class,
        );

        $encryptionMethod = EncryptionMethod::getChildrenOfClass($xml);
        Assert::maxCount(
            $encryptionMethod,
            1,
            'No more than one EncryptionMethod element allowed in <xenc:EncryptedData>.',
            TooManyElementsException::class,
        );

        $keyInfo = KeyInfo::getChildrenOfClass($xml);
        Assert::maxCount(
            $keyInfo,
            1,
            'No more than one KeyInfo element allowed in <xenc:EncryptedData>.',
            TooManyElementsException::class,
        );

        return new static(
            $cipherData[0],
            self::getAttribute($xml, 'Id', null),
            self::getAttribute($xml, 'Type', null),
            self::getAttribute($xml, 'MimeType', null),
            self::getAttribute($xml, 'Encoding', null),
            count($encryptionMethod) === 1 ? $encryptionMethod[0] : null,
            count($keyInfo) === 1 ? $keyInfo[0] : null,
        );
    }


    /**
     * @inheritDoc
     */
    public function toXML(DOMElement $parent = null): DOMElement
    {
        $e = $this->instantiateParentElement($parent);

        if ($this->id !== null) {
            $e->setAttribute('Id', $this->id);
        }

        if ($this->type !== null) {
            $e->setAttribute('Type', $this->type);
        }

        if ($this->mimeType !== null) {
            $e->setAttribute('MimeType', $this->mimeType);
        }

        if ($this->encoding !== null) {
            $e->setAttribute('Encoding', $this->encoding);
        }

        if ($this->encryptionMethod !== null) {
            $this->encryptionMethod->toXML($e);
        }

        if ($this->keyInfo !== null) {
            $this->keyInfo->toXML($e);
        }

        $this->cipherData->toXML($e);

        return $e;
    }
}
