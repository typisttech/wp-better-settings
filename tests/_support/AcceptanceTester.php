<?php

declare(strict_types=1);

namespace TypistTech\WPBetterSettings;

/**
 * Inherited Methods
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    public function amOnWPBSOptionPage()
    {
        $this->loginAsAdmin();
        $this->waitForText('Dashboard', 10, 'h1');
        $this->waitForElementVisible("a[href$='admin.php?page=wpbs_1']", 10);

        $this->click('WP Better Settings');
        $this->click('WP Better Settings');
        $this->waitForText('WP Better Settings', 10, 'h1');
    }
}
