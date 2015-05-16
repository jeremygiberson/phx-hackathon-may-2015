<?php

namespace ZfSimpleMigrations\Migrations;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Ddl\Column\Integer;
use Zend\Db\Sql\Ddl\Column\Varchar;
use Zend\Db\Sql\Ddl\Constraint\ForeignKey;
use Zend\Db\Sql\Ddl\Constraint\PrimaryKey;
use Zend\Db\Sql\Ddl\Constraint\UniqueKey;
use Zend\Db\Sql\Ddl\CreateTable;
use Zend\Db\Sql\Ddl\DropTable;
use Zend\Db\Sql\Ddl\Index\Index;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfSimpleMigrations\Library\AbstractMigration;
use Zend\Db\Metadata\MetadataInterface;

class Version20150516200445 extends AbstractMigration implements ServiceLocatorAwareInterface
{
    public static $description = "Initialize reminder database";

    /** @var  ServiceLocatorInterface */
    protected $serviceLocator;

    public function up(MetadataInterface $schema)
    {
        $subscription = new CreateTable('subscription');
        $subscription->addColumn(new Integer('subscription_id'));
        $subscription->addColumn(new Varchar('email', 255));
        $subscription->addColumn(new Varchar('address', 255));
        $subscription->addConstraint(new PrimaryKey('subscription_id'));
        $subscription->addConstraint(new UniqueKey(['email','address']));
        //$subscription->addConstraint(new Index(['email', 'address']));

        $this->addSql($subscription->getSqlString($this->getPlatform()));

        $reminder = new CreateTable('reminder');
        $reminder->addColumn(new Integer('reminder_id'));
        $reminder->addColumn(new Integer('subscription_id'));
        $reminder->addColumn(new Varchar('day', 10));
        $reminder->addColumn(new Varchar('service', 10));
        $reminder->addConstraint(new PrimaryKey('reminder_id'));
        $reminder->addConstraint(new ForeignKey('subscription_fk',
            'subscription_id', 'subscription', 'subscription_id'));
        //$reminder->addConstraint(new Index(['day']));
        //$reminder->addConstraint(new Index(['subscription_id']));

        $this->addSql($reminder->getSqlString($this->getPlatform()));
    }

    public function down(MetadataInterface $schema)
    {
        $dropTable = new DropTable('subscription');
        $this->addSql($dropTable->getSqlString($this->getPlatform()));

        $dropTable = new DropTable('reminder');
        $this->addSql($dropTable->getSqlString($this->getPlatform()));
    }

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }


    protected function getPlatform()
    {
        /** @var Adapter $adapter */
        $adapter = $this->getServiceLocator()->get(Adapter::class);
        return $adapter->getPlatform();
    }
}
