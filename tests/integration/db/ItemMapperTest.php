<?php

namespace OCA\News\Db;

require_once __DIR__ . '/../bootstrap.php';

use \OCA\News\AppInfo\Application;
use \OCA\News\Tests\Integration\NewsIntegrationTest;

class ItemMapperTest extends NewsIntegrationTest {

    private $container;
    private $itemMapper;

    protected function setUp() {
        parent::setUpOwnCloud();
        $app = new Application();
        $this->container = $app->getContainer();
        $this->itemMapper = $this->container->query('ItemMapper');
    }


    public function testInsert() {
        $item = new Item();
        $item->setTitle('my title');
        $item->setGuid('test');
        $item->setFeedId(3);
        $item->setUnread();

        $created = $this->itemMapper->insert($item);

        $fetched = $this->itemMapper->find($created->getId(), $this->userId);

        $this->assertEquals($item->getTitle(), $fetched->getTitle());
        $this->assertEquals($item->getGuid(), $fetched->getGuid());
        $this->assertEquals($item->getGuidHash(), $fetched->getGuidHash());
        $this->assertEquals($item->getFeedId(), $fetched->getFeedId());
        $this->assertEquals($item->isRead(), $fetched->isRead());
    }

}