<?

namespace Ebola\FixPostComments;

use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Type\DateTime;
use Ebola\FixPostComments\DataMapper\LogTable;
use Ebola\FixPostComments\DataMapper\CommentsTable;

class Agents
{
    public function UnFix()
    {
        if (!Loader::includeModule("socialnetwork")) {
            return "\Ebola\FixPostComments\Agents::UnFix();";
        }

        $connection = Application::getConnection();
        if (!($connection->isTableExists("b_fix_comments"))) {
            return "\Ebola\FixPostComments\Agents::UnFix();";
        }

        $shift = Option::get("ebola.fixpostcomment", "EBOLA_FIXPOSTCOMMENT_SHIFT_DAYS", 0);

        $objDate = new DateTime();

        $dbResult = CommentsTable::getList([
            'select' => ['DATE_ADD', 'ID', 'DATE_START']
        ]);

        while ($arItem = $dbResult->fetch()) {

            $date = $arItem['DATE_ADD'];
            if ($date->add("+$shift day") == $objDate) {

                $obResult = CommentsTable::delete($arItem['ID']);

                if (!$obResult->isSuccess()) {
                    return "\Ebola\FixPostComments\Agents::UnFix();";
                }

                $obResult = LogTable::update(
                    $arItem['ID'],
                    ['LOG_DATE' => $arItem['DATE_START']]
                );

                if (!$obResult->isSuccess()) {
                    return "\Ebola\FixPostComments\Agents::UnFix();";
                }
            }
        }
        if ($shift <= 0) {
            return "\Ebola\FixPostComments\Agents::UnFix();";
        }
        return "\Ebola\FixPostComments\Agents::UnFix();";
    }
}

?>