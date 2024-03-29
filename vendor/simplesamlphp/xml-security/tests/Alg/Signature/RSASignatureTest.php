<?php

namespace SimpleSAML\XMLSecurity\Test\Alg\Signature;

use PHPUnit\Framework\TestCase;
use SimpleSAML\XMLSecurity\Alg\Signature\RSA;
use SimpleSAML\XMLSecurity\Alg\Signature\SignatureAlgorithmFactory;
use SimpleSAML\XMLSecurity\Constants as C;
use SimpleSAML\XMLSecurity\Key\PrivateKey;
use SimpleSAML\XMLSecurity\Key\PublicKey;
use SimpleSAML\XMLSecurity\Key\SymmetricKey;
use SimpleSAML\XMLSecurity\Key\X509Certificate;
use TypeError;

use function bin2hex;
use function hex2bin;

/**
 * Tests for SimpleSAML\XMLSecurity\Alg\Signature\RSA.
 *
 * @package SimpleSAML\XMLSecurity\Alg
 */
final class RSASignatureTest extends TestCase
{
    /** @var \SimpleSAML\XMLSecurity\Key\PrivateKey */
    protected PrivateKey $privateKey;

    /** @var \SimpleSAML\XMLSecurity\Key\PublicKey */
    protected PublicKey $publicKey;

    /** @var string */
    protected string $plaintext = 'plaintext';

    /** @var \SimpleSAML\XMLSecurity\Alg\Signature\SignatureAlgorithmFactory */
    protected SignatureAlgorithmFactory $factory;


    public function setUp(): void
    {
        $this->publicKey = PublicKey::fromFile('tests/pubkey.pem');
        $this->privateKey = PrivateKey::fromFile('tests/privkey.pem');
        $this->factory = new SignatureAlgorithmFactory([]);
    }


    /**
     * Test RSA signing.
     */
    public function testSign(): void
    {
        // test RSA-SHA1
        $rsa = $this->factory->getAlgorithm(C::SIG_RSA_SHA1, $this->privateKey);
        $this->assertEquals(
            '002e8007f09d327b48a7393c9e3666c0d0d73a437804d6e71191bc227546d62351cda58173d69dd792c783337c4ed903a59b6fd' .
            'fd221a0dd22e8632e66c020e1c07400b02625fcdb3821495593e0e0a776a616a2cdf268b3070f7d02e78fdc531c02759ad1fc29' .
            '2ee2f77dcb8a0232cb32e8808c57cb592329d48168bc73936d468421a83446a429cd03bd82aa4a099c2585e0ee60e8afc9b7731' .
            'd07b00ac8e9f8e7e8c0f526506520c717af5926395b49e6644015e166b462649f65a7d9728ce8872d3b6b0219550b4944cb6286' .
            'e1278908c516be2391928df8d81298e619d0a8711c58e79e5536d7c39fa1b1ffc81d96be6e1b733a8248d5fee2866c7f6e48',
            bin2hex($rsa->sign($this->plaintext)),
        );

        // test RSA-SHA224
        $rsa = $this->factory->getAlgorithm(C::SIG_RSA_SHA224, $this->privateKey);
        $this->assertEquals(
            'de43cf0f92c3bcabaf5087240fa02a07d7801600ea5800a2078372ff6e6376a98e1d05d017748c2cd3003275df08c3cf93342ed' .
            '1ba7a3b1b20237c3883b40a8988b9e29b3b42967da926fec2c4f8f10859089f4b41faa2b0996bbc6b968ac71036a16125f97e47' .
            '114c4d95dccd44797f40ef1e70522dc470836b8cd218b10426d5e6a1cdb73544cd9826cb18116200b003499372e6d4872f31634' .
            '47ab630697aa4225584d086452dd94b6e0d60db519366a3071a280d447c7f19d32b128ec242137a569cf84d64313ed68cf1d1e4' .
            '3d044f07524b2be209967ce3b1959685890e89b7a64e527fe0fb7a67f04b34718bbf2a5bb38760fe1020c7642659f9eadfad',
            bin2hex($rsa->sign($this->plaintext)),
        );

        // test RSA-SHA256
        $rsa = $this->factory->getAlgorithm(C::SIG_RSA_SHA256, $this->privateKey);
        $this->assertEquals(
            '4c1fee00368a4c0abd37bc9f0d30d675c68b7415526e128334cdbe1c8ea3c7da40f65ad4385f1b1bdbfa151ffa3d0da120f77ce' .
            '920180b777494b1771ece238098f0ca69569b46a716d1dc4bac240720d61de6b7547877b357c441cc9e1e4d2fbae952fbbc18eb' .
            'c4597474474fdd7fce8e2d09ea734bfcc108aca79f2ebf6683ba7380f38c781983ddeb43df1914811bd695efb87f4c55f6180aa' .
            'b481b6a125e7891de8eb1810013b90a118394b487bde01d201021810530aae7b2fd22842e4f8c51b788d3cfca07fa1eda8e72ee' .
            '76913c8094436212ff57b3248a03b4594ecae274086bb0d0363abe728c982fe51d57d9f7fe81461c46b4b36031a5549212ca',
            bin2hex($rsa->sign($this->plaintext)),
        );

        // test RSA-SHA384
        $rsa = $this->factory->getAlgorithm(C::SIG_RSA_SHA384, $this->privateKey);
        $this->assertEquals(
            '97bb8bbd713caaf720671b8178ff8645da6b8c5cf573f2b21b70915ed94200de561e86d6acdfdadac4544212f9ec7fabee0406a' .
            '20ec1386918916430579d1565809a8313a540a9a35de6ef8131b8c4b192508c0b0958daa197f69b705fb46ff823ec8a6564f261' .
            'd4f2db34a2248c3876aa248e297a9f28528957ffa773bc343e7eeaff20b06f4b6271de9cbf2c3dd84deeb65589f82f8806ab8a5' .
            'bfa239d14933efb81698d7a3f14a7cfdeb736b59ea35a24fb81c98add03635d552a7d93252104ee64240cdbe85ebf94c2546662' .
            'f52cfd55b4227f8c77cb6656a089041a6db2332c3d20ef7ea07535d449a6de29186e4203ae3ae52c0f92bf9e782565b888f0',
            bin2hex($rsa->sign($this->plaintext)),
        );

        // test RSA-SHA512
        $rsa = $this->factory->getAlgorithm(C::SIG_RSA_SHA512, $this->privateKey);
        $this->assertEquals(
            'd91bd94dbb71c15248f364898d7c88d112440211f685b8ed61b20b6bfcd7805ad054db70e97e3c8060d1dd219b186c603f027a6' .
            '668a5076da14e4e95c4451f054cf4b2b34e3db5bcdf1bf4ec5a79e08b9413c8f4fbfa2274bb42322b55d2db6048c91bbd84fded' .
            'eebf13b254bcd7feeb9328046f56f11643047d02efb1654797b1bac8afe4196b801340c0e28eedf29f62ffeb5ffdd16a9e1701d' .
            'bcecebb8c6570170ccb0f6cdd795af0a3b5c8e6559ff3ebfa9d0f923ca5f14eded7aaf15f82f879f956a9d72730a1ee97a834f8' .
            '92d6793a94679182402cc4fd8ae39be0f280da04953b640d76044179bca311a04b6a77d6949d126d81fda2b3b5e2146d0c5b',
            bin2hex($rsa->sign($this->plaintext)),
        );

        // test RSA-RIPEMD160
        $rsa = $this->factory->getAlgorithm(C::SIG_RSA_RIPEMD160, $this->privateKey);
        $this->assertEquals(
            '61c0f9e5e4db30ec33ce59a082a161890cc3f3ea16c66a8a7df732db62e46dd21e0ef4eca92920109bd5defe15f804aae90a29d' .
            '7b0898487d36dbbc4cf567785a9537ef746dd710e17115d76cb63832aab2778e1ceed484d39e88ccf57d10248d7dfdfd3102730' .
            'e81684ac7ecc587676dd69369cda6eba531c706ee41bdde40b5bfae23cee961d727f29f38f4d0900885762f8630f2a49c00306d' .
            'f1e3dcbb60e6eb62356dc83dc814c4a445048e84bd858f8fd28018fc1adfa70ea0c387673a7e43173e003fd50f8a79a7ef753a1' .
            'c6df98c353a478dc894a4efeafeafde1a8935575f4b25f794d68c066b06ff9064db8629645b9c007c48ddafae235b660ca3c',
            bin2hex($rsa->sign($this->plaintext)),
        );
    }


    /**
     * Test RSA signature verification.
     */
    public function testVerify(): void
    {
        // test RSA-SHA1
        $rsa = $this->factory->getAlgorithm(C::SIG_RSA_SHA1, $this->publicKey);
        $this->assertTrue($rsa->verify(
            $this->plaintext,
            hex2bin(
                '002e8007f09d327b48a7393c9e3666c0d0d73a437804d6e71191bc227546d62351cda58173d69dd792c783337c4ed903a59' .
                'b6fdfd221a0dd22e8632e66c020e1c07400b02625fcdb3821495593e0e0a776a616a2cdf268b3070f7d02e78fdc531c0275' .
                '9ad1fc292ee2f77dcb8a0232cb32e8808c57cb592329d48168bc73936d468421a83446a429cd03bd82aa4a099c2585e0ee6' .
                '0e8afc9b7731d07b00ac8e9f8e7e8c0f526506520c717af5926395b49e6644015e166b462649f65a7d9728ce8872d3b6b02' .
                '19550b4944cb6286e1278908c516be2391928df8d81298e619d0a8711c58e79e5536d7c39fa1b1ffc81d96be6e1b733a824' .
                '8d5fee2866c7f6e48',
            ),
        ));

        // test RSA-SHA1 with certificate
        $rsa = $this->factory->getAlgorithm(C::SIG_RSA_SHA1, X509Certificate::fromFile('tests/mycert.pem'));
        $this->assertTrue($rsa->verify(
            $this->plaintext,
            hex2bin(
                '002e8007f09d327b48a7393c9e3666c0d0d73a437804d6e71191bc227546d62351cda58173d69dd792c783337c4ed903a59' .
                'b6fdfd221a0dd22e8632e66c020e1c07400b02625fcdb3821495593e0e0a776a616a2cdf268b3070f7d02e78fdc531c0275' .
                '9ad1fc292ee2f77dcb8a0232cb32e8808c57cb592329d48168bc73936d468421a83446a429cd03bd82aa4a099c2585e0ee6' .
                '0e8afc9b7731d07b00ac8e9f8e7e8c0f526506520c717af5926395b49e6644015e166b462649f65a7d9728ce8872d3b6b02' .
                '19550b4944cb6286e1278908c516be2391928df8d81298e619d0a8711c58e79e5536d7c39fa1b1ffc81d96be6e1b733a824' .
                '8d5fee2866c7f6e48',
            ),
        ));

        // test RSA-SHA224
        $rsa = $this->factory->getAlgorithm(C::SIG_RSA_SHA224, $this->publicKey);
        $this->assertTrue($rsa->verify(
            $this->plaintext,
            hex2bin(
                'de43cf0f92c3bcabaf5087240fa02a07d7801600ea5800a2078372ff6e6376a98e1d05d017748c2cd3003275df08c3cf933' .
                '42ed1ba7a3b1b20237c3883b40a8988b9e29b3b42967da926fec2c4f8f10859089f4b41faa2b0996bbc6b968ac71036a161' .
                '25f97e47114c4d95dccd44797f40ef1e70522dc470836b8cd218b10426d5e6a1cdb73544cd9826cb18116200b003499372e' .
                '6d4872f3163447ab630697aa4225584d086452dd94b6e0d60db519366a3071a280d447c7f19d32b128ec242137a569cf84d' .
                '64313ed68cf1d1e43d044f07524b2be209967ce3b1959685890e89b7a64e527fe0fb7a67f04b34718bbf2a5bb38760fe102' .
                '0c7642659f9eadfad',
            ),
        ));

        // test RSA-SHA256
        $rsa = $this->factory->getAlgorithm(C::SIG_RSA_SHA256, $this->publicKey);
        $this->assertTrue($rsa->verify(
            $this->plaintext,
            hex2bin(
                '4c1fee00368a4c0abd37bc9f0d30d675c68b7415526e128334cdbe1c8ea3c7da40f65ad4385f1b1bdbfa151ffa3d0da120f' .
                '77ce920180b777494b1771ece238098f0ca69569b46a716d1dc4bac240720d61de6b7547877b357c441cc9e1e4d2fbae952' .
                'fbbc18ebc4597474474fdd7fce8e2d09ea734bfcc108aca79f2ebf6683ba7380f38c781983ddeb43df1914811bd695efb87' .
                'f4c55f6180aab481b6a125e7891de8eb1810013b90a118394b487bde01d201021810530aae7b2fd22842e4f8c51b788d3cf' .
                'ca07fa1eda8e72ee76913c8094436212ff57b3248a03b4594ecae274086bb0d0363abe728c982fe51d57d9f7fe81461c46b' .
                '4b36031a5549212ca',
            ),
        ));

        // test RSA-SHA384
        $rsa = $this->factory->getAlgorithm(C::SIG_RSA_SHA384, $this->publicKey);
        $this->assertTrue($rsa->verify(
            $this->plaintext,
            hex2bin(
                '97bb8bbd713caaf720671b8178ff8645da6b8c5cf573f2b21b70915ed94200de561e86d6acdfdadac4544212f9ec7fabee0' .
                '406a20ec1386918916430579d1565809a8313a540a9a35de6ef8131b8c4b192508c0b0958daa197f69b705fb46ff823ec8a' .
                '6564f261d4f2db34a2248c3876aa248e297a9f28528957ffa773bc343e7eeaff20b06f4b6271de9cbf2c3dd84deeb65589f' .
                '82f8806ab8a5bfa239d14933efb81698d7a3f14a7cfdeb736b59ea35a24fb81c98add03635d552a7d93252104ee64240cdb' .
                'e85ebf94c2546662f52cfd55b4227f8c77cb6656a089041a6db2332c3d20ef7ea07535d449a6de29186e4203ae3ae52c0f9' .
                '2bf9e782565b888f0',
            ),
        ));

        // test RSA-SHA512
        $rsa = $this->factory->getAlgorithm(C::SIG_RSA_SHA512, $this->publicKey);
        $this->assertTrue($rsa->verify(
            $this->plaintext,
            hex2bin(
                'd91bd94dbb71c15248f364898d7c88d112440211f685b8ed61b20b6bfcd7805ad054db70e97e3c8060d1dd219b186c603f0' .
                '27a6668a5076da14e4e95c4451f054cf4b2b34e3db5bcdf1bf4ec5a79e08b9413c8f4fbfa2274bb42322b55d2db6048c91b' .
                'bd84fdedeebf13b254bcd7feeb9328046f56f11643047d02efb1654797b1bac8afe4196b801340c0e28eedf29f62ffeb5ff' .
                'dd16a9e1701dbcecebb8c6570170ccb0f6cdd795af0a3b5c8e6559ff3ebfa9d0f923ca5f14eded7aaf15f82f879f956a9d7' .
                '2730a1ee97a834f892d6793a94679182402cc4fd8ae39be0f280da04953b640d76044179bca311a04b6a77d6949d126d81f' .
                'da2b3b5e2146d0c5b',
            ),
        ));

        // test RSA-RIPEMD160
        $rsa = $this->factory->getAlgorithm(C::SIG_RSA_RIPEMD160, $this->publicKey);
        $this->assertTrue($rsa->verify(
            $this->plaintext,
            hex2bin(
                '61c0f9e5e4db30ec33ce59a082a161890cc3f3ea16c66a8a7df732db62e46dd21e0ef4eca92920109bd5defe15f804aae90' .
                'a29d7b0898487d36dbbc4cf567785a9537ef746dd710e17115d76cb63832aab2778e1ceed484d39e88ccf57d10248d7dfdf' .
                'd3102730e81684ac7ecc587676dd69369cda6eba531c706ee41bdde40b5bfae23cee961d727f29f38f4d0900885762f8630' .
                'f2a49c00306df1e3dcbb60e6eb62356dc83dc814c4a445048e84bd858f8fd28018fc1adfa70ea0c387673a7e43173e003fd' .
                '50f8a79a7ef753a1c6df98c353a478dc894a4efeafeafde1a8935575f4b25f794d68c066b06ff9064db8629645b9c007c48' .
                'ddafae235b660ca3c',
            ),
        ));
    }


    /**
     * Test that verification fails properly.
     */
    public function testVerificationFailure(): void
    {
        // test wrong plaintext
        $rsa = $this->factory->getAlgorithm(C::SIG_RSA_SHA1, $this->publicKey);
        $this->assertFalse($rsa->verify(
            $this->plaintext . '.',
            '002e8007f09d327b48a7393c9e3666c0d0d73a437804d6e71191bc227546d62351cda58173d69dd792c783337c4ed903a59' .
            'b6fdfd221a0dd22e8632e66c020e1c07400b02625fcdb3821495593e0e0a776a616a2cdf268b3070f7d02e78fdc531c0275' .
            '9ad1fc292ee2f77dcb8a0232cb32e8808c57cb592329d48168bc73936d468421a83446a429cd03bd82aa4a099c2585e0ee6' .
            '0e8afc9b7731d07b00ac8e9f8e7e8c0f526506520c717af5926395b49e6644015e166b462649f65a7d9728ce8872d3b6b02' .
            '19550b4944cb6286e1278908c516be2391928df8d81298e619d0a8711c58e79e5536d7c39fa1b1ffc81d96be6e1b733a824' .
            '8d5fee2866c7f6e48',
        ));

        // test wrong signature
        $this->assertFalse($rsa->verify(
            $this->plaintext,
            '002e8007f09d327b48a7393c9e3666c0d0d73a437804d6e71191bc227546d62351cda58173d69dd792c783337c4ed903a59' .
            'b6fdfd221a0dd22e8632e66c020e1c07400b02625fcdb3821495593e0e0a776a616a2cdf268b3070f7d02e78fdc531c0275' .
            '9ad1fc292ee2f77dcb8a0232cb32e8808c57cb592329d48168bc73936d468421a83446a429cd03bd82aa4a099c2585e0ee6' .
            '0e8afc9b7731d07b00ac8e9f8e7e8c0f526506520c717af5926395b49e6644015e166b462649f65a7d9728ce8872d3b6b02' .
            '19550b4944cb6286e1278908c516be2391928df8d81298e619d0a8711c58e79e5536d7c39fa1b1ffc81d96be6e1b733a824' .
            '8d5fee2866c7f6e48',
        ));

        // test wrong key
        $rsa = $this->factory->getAlgorithm(C::SIG_RSA_SHA1, PublicKey::fromFile('tests/wrongpubkey.pem'));
        $this->assertFalse($rsa->verify(
            $this->plaintext,
            '002e8007f09d327b48a7393c9e3666c0d0d73a437804d6e71191bc227546d62351cda58173d69dd792c783337c4ed903a59' .
            'b6fdfd221a0dd22e8632e66c020e1c07400b02625fcdb3821495593e0e0a776a616a2cdf268b3070f7d02e78fdc531c0275' .
            '9ad1fc292ee2f77dcb8a0232cb32e8808c57cb592329d48168bc73936d468421a83446a429cd03bd82aa4a099c2585e0ee6' .
            '0e8afc9b7731d07b00ac8e9f8e7e8c0f526506520c717af5926395b49e6644015e166b462649f65a7d9728ce8872d3b6b02' .
            '19550b4944cb6286e1278908c516be2391928df8d81298e619d0a8711c58e79e5536d7c39fa1b1ffc81d96be6e1b733a824' .
            '8d5fee2866c7f6e48',
        ));
    }


    /**
     * Test that verification fails when the wrong type of key is passed.
     */
    public function testVerifyWithSymmetricKey(): void
    {
        $key = SymmetricKey::generate(16);

        $this->expectException(TypeError::class);
        new RSA($key);
    }
}
