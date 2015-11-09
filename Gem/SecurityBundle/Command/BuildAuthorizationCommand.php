<?php
/**
 * Code Owner: Duy Huynh
 * Modified date: 11/9/2015
 * Modified by: Duy Huynh
 */

namespace Gem\SecurityBundle\Command;


use Gem\SystemBundle\Config\Entities;
use Gem\SystemBundle\Lib\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class BuildAuthorizationCommand extends ContainerAwareCommand {

    protected function configure()
    {
        $this->setName("gem:auth:build", "Build authorization");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = EntityManager::getEntityManager();

        $en1 = Entities::getEntityPath("roles").' a1, '; //a1
        $en2 = Entities::getEntityPath("role_module").' a2, '; //a2
        $en3 = Entities::getEntityPath("modules").' a3, '; //a3
        $en4 = Entities::getEntityPath("module_function").' a4, ';//a5
        $en5 = Entities::getEntityPath("functions").' a5, ';//a4
        $en6 = Entities::getEntityPath("function_action").' a6, ';//a7
        $en7 = Entities::getEntityPath("actions").' a7 ';//a6

        $conditions = " a1.id=a2.roleid AND a2.moduleid=a3.id AND a3.id=a4.moduleid AND ".
            "a4.functionid=a5.id AND a5.id=a6.functionid AND a6.actionid=a7.id";

        $queryStr = "SELECT a1.id roleid, a3.id moduleid, a5.id functionid, a7.id actionid FROM ".$en1. $en2. $en3. $en4.
            $en5. $en6.$en7. " WHERE ".$conditions;


        $query = $em->createQuery($queryStr);

        $results = $query->getArrayResult();
        $dataResult = array();

        foreach($results as $data){

            $str = $data['roleid']."-".$data['functionid']."-".$data['actionid'];

            if(!in_array($str, $dataResult)){
                $dataResult[] = $str;
            }
        }

        $this->cacheFile($dataResult);

    }


    private function cacheFile($data)
    {
        $str = "<?php"."\n";
        $str .= "namespace Gem\SecurityBundle\Resources;"."\n\n";
        $str .= "class AuthorizationData {"."\n\n";

        $datastr = "\t".'protected static $data = array('."\n";

        foreach($data as $r){
            $datastr .= "\t\t"."'".$r."'=>true,"."\n";
        }

        $datastr .= "\t);";

        $str .= $datastr;

        $str .= "\n\n\t".'public static function checkAuthorize($key)'."\n\t{\n";
        $str .= "\t\t".'if (!isset(static::$data[$key]))'."\n\t\t\treturn array();";
        $str .= "\n\t\t".'return static::$data[$key];';
        $str .= "\n\t"."}";
        $str .= "\n"."}";

        $fs = new Filesystem();

        $fs->dumpFile(__DIR__."/../Resources/AuthorizationData.php", $str);
    }

}