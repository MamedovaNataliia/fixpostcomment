<?
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;

try {
    Loader::registerAutoloadClasses(
        "ebola.fixpostcomment",
        [
            "Ebola\\FixPostComments\\Agents" => "lib/agents.php",
            "Ebola\\FixPostComments\\DataMapper\\CommentsTable" => "lib/datamapper/commentstable.php",
            "Ebola\\FixPostComments\\DataMapper\\LogTable" => "lib/datamapper/logtable.php"
        ]
    );
}catch (LoaderException $ex){}
?>