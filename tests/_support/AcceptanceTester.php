<?php


/**
 * Inherited Methods
 * @method void wantToTest( $text )
 * @method void wantTo( $text )
 * @method void execute( $callable )
 * @method void expectTo( $prediction )
 * @method void expect( $prediction )
 * @method void amGoingTo( $argumentation )
 * @method void am( $role )
 * @method void lookForwardTo( $achieveValue )
 * @method void comment( $description )
 * @method \Codeception\Lib\Friend haveFriend( $name, $actorClass = null )
 *
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /**
     * Define custom actions here
     */

    /**
     * @since 0.4.0
     * @return void
     * @throws \Exception
     */
    public function amOnWPBSOptionPage()
    {
        $I = $this;

        $I->loginAsAdmin();
        $I->waitForText('Dashboard', 10, 'h1');
        $I->waitForElementVisible("a[href$='admin.php?page=wpbs_1']", 10);

        $I->click('WP Better Settings');
        $I->click('WP Better Settings');
        $I->waitForText('WP Better Settings', 10, 'h1');
    }
}
