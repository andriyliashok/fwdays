<?php

namespace Stfalcon\Bundle\SponosorBundle\Tests\Entity;

use Stfalcon\Bundle\SponsorBundle\Entity\Sponsor;

/**
 * Test cases for sponosr entity.
 */
class SponsorEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test setter and getter methods for slug.
     */
    public function testSetAndGetSponsorSlug()
    {
        $slug = 'coca-cola-fanta-sprite';

        $sponsor = new Sponsor();
        $sponsor->setSlug($slug);

        $this->assertEquals($sponsor->getSlug(), $slug);
    }

    /**
     * Test setter and getter methods for name.
     */
    public function testSetAndGetSponsorName()
    {
        $slug = 'Google Inc.';

        $sponsor = new Sponsor();
        $sponsor->setName($slug);

        $this->assertEquals($sponsor->getName(), $slug);
    }

    /**
     * Test setter and getter methods for logo.
     */
    public function testSetAndGetSponsorLogo()
    {
        $slug = 'logo.jpg';

        $sponsor = new Sponsor();
        $sponsor->setLogo($slug);

        $this->assertEquals($sponsor->getLogo(), $slug);
    }

    /**
     * Test setter and getter methods for site.
     */
    public function testSetAndGetSponsorSite()
    {
        $slug = 'htp://site.com';

        $sponsor = new Sponsor();
        $sponsor->setSite($slug);

        $this->assertEquals($sponsor->getSite(), $slug);
    }

    /**
     * Test setter and getter methods for file.
     */
    public function testSetAndGetSponsorFile()
    {
        $slug = 'file';

        $sponsor = new Sponsor();
        $sponsor->setFile($slug);

        $this->assertEquals($sponsor->getFile(), $slug);
    }

    /**
     * Test setter and getter methods for about.
     */
    public function testSetAndGetSponsorAbout()
    {
        $slug = 'This is very short about me story.';

        $sponsor = new Sponsor();
        $sponsor->setAbout($slug);

        $this->assertEquals($sponsor->getAbout(), $slug);
    }

    /**
     * Test empty fields.
     */
    public function testEmptyPerson()
    {
        $sponsor = new Sponsor();

        $this->assertNull($sponsor->getId());
        $this->assertNull($sponsor->getSlug());
        $this->assertNull($sponsor->getName());
        $this->assertNull($sponsor->getSite());
        $this->assertNull($sponsor->getAbout());
        $this->assertNull($sponsor->getLogo());
        $this->assertNull($sponsor->getFile());
        $this->assertNull($sponsor->getCreatedAt());
        $this->assertNull($sponsor->getUpdatedAt());
    }
}
