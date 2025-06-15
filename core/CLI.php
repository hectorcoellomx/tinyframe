<?php
namespace Core;

class CLI
{
    public function handle($command, $args)
    {
        $entities = explode(',', $args[0] ?? '');

        if (empty($entities[0])) {
            echo "\nDebes indicar al menos un elemento.\n";
            return;
        }

        switch ($command) {
            case 'c':
                foreach ($entities as $entity) {
                    $this->makeController($entity);
                }
                break;
            case 'm':
                foreach ($entities as $entity) {
                    $this->makeModel($entity);
                }
                break;
            case 's':
                foreach ($entities as $entity) {
                    $this->makeService($entity);
                }
                break;
            case 'mi':
                foreach ($entities as $entity) {
                    $this->makeMiddleware($entity);
                }
                break;
            case 'li':
                foreach ($entities as $entity) {
                    $this->makeLibrary($entity);
                }
                break;
            case 'full':
                foreach ($entities as $entity) {
                    $this->makeModel($entity);
                    $this->makeService($entity);
                    $this->makeController($entity);
                }
                break;
            default:
                echo "Comando no reconocido: $command\n";
        }
    }

    protected function makeController($name)
    {
        if (!$name) {
            echo "\nFalta el nombre del controlador.\n";
            return;
        }

        $className = ucfirst($name) . 'Controller';
        $filePath = __DIR__ . '/../app/controllers/' . $className . '.php';

        if (file_exists($filePath)) {
            echo "\nEl controlador $className ya existe.\n";
            return;
        }

        $filePathService = __DIR__ . '/../app/services/' . ucfirst($name) . 'Service.php';

        if (file_exists($filePathService)) {
            $use_service = "\n\nuse App\\Services\\" . ucfirst($name) . "Service;";
            $instanceService = "\n\n        \$this->service = new " . ucfirst($name) . "Service();";
        }else{
            $use_service = "";
            $instanceService = "";
        }

        $template = "<?php \n\nnamespace App\\Controllers;\n\nuse Core\\Controller;\nuse Core\\Request;{$use_service}\n\nclass {$className} extends Controller {\n\n    public function __construct(){{$instanceService}\n\n    }\n    \n    public function index(Request \$req){\n\n    }\n\n}\n\n?>";

        file_put_contents($filePath, $template);
        echo "\nControlador $className creado en app/controllers.\n";
    }

    protected function makeModel($name)
    {
        if (!$name) {
            echo "\nFalta el nombre del modelo.\n";
            return;
        }

        $className = ucfirst($name);
        $filePath = __DIR__ . '/../app/models/' . $className . '.php';

        if (file_exists($filePath)) {
            echo "\nEl modelo $className ya existe.\n";
            return;
        }

        $tableName = strtolower($className) . 's';

        $template = "<?php \n\nnamespace App\\Models;\n\nuse Core\\Databases\\DB;\n\nclass {$className}\n{\n\n    public function find(\$id){\n        \$db = DB::init();\n        return \$db->db_select_row(\"SELECT * FROM {$tableName} WHERE id=?\", [ \$id ]);\n    }\n\n    public function all(){\n        \$db = DB::init();\n        return \$db->db_select(\"SELECT * FROM {$tableName}\");\n    }\n\n    public function create(\$name){\n        \$db = DB::init();\n        return \$db->db_insert_lastid(\"INSERT INTO {$tableName} (name) VALUES (?)\", [ \$name ]);\n    }\n\n    public function update(\$id, \$data){\n        \$db = DB::init();\n        return \$db->db_update(\"UPDATE {$tableName} SET name = ? WHERE id = ?\", [ \$data['name'], \$id ]);\n    }\n\n    public function destroy(\$id){\n        \$db = DB::init();\n        return \$db->db_delete(\"DELETE from {$tableName} WHERE id = ?\", [ \$id ]);\n    }\n\n}\n";

        file_put_contents($filePath, $template);
        echo "\nModelo $className creado en app/models.\n";
    }

    protected function makeLibrary($name)
    {
        if (!$name) {
            echo "\nFalta el nombre de la librería.\n";
            return;
        }

        $className = ucfirst($name);
        $filePath = __DIR__ . '/../app/libraries/' . $className . '.php';

        if (file_exists($filePath)) {
            echo "\nLa librería $className ya existe.\n";
            return;
        }

        $tableName = strtolower($className) . 's';

        $template = "<?php \n\nnamespace App\\Libraries;\n\nclass {$className}\n{\n\n\n}\n";

        file_put_contents($filePath, $template);
        echo "\nLibrería $className creada en app/libraries.\n";
    }


    protected function makeService($name)
    {
        if (!$name) {
            echo "\nFalta el nombre del servicio.\n";
            return;
        }

        $className = ucfirst($name) . 'Service';
        $filePath = __DIR__ . '/../app/services/' . $className . '.php';

        if (file_exists($filePath)) {
            echo "\nEl servicio $className ya existe.\n";
            return;
        }

        $filePathModel = __DIR__ . '/../app/models/' . ucfirst($name) . '.php';

        if (file_exists($filePathModel)) {
            $use_model = "use App\\Models\\" . ucfirst($name) . ";\n\n";
        }else{
            $use_model = "";
        }

        $template = "<?php \n\nnamespace App\\Services;\n\n{$use_model}class {$className} {\n\n\n}\n";

        file_put_contents($filePath, $template);
        echo "\nServicio $className creado en app/services.\n";
    }

    protected function makeMiddleware($name)
    {
        if (!$name) {
            echo "\nFalta el nombre del middleware.\n";
            return;
        }

        $className = ucfirst($name);
        $filePath = __DIR__ . '/../app/middlewares/' . $className . '.php';

        if (file_exists($filePath)) {
            echo "\nEl middleware $className ya existe.\n";
            return;
        }

        $template = "<?php \n\nnamespace App\\Middlewares;\n\nclass {$className} {\n\n    public function run(){\n        // Here is the code of your middleware\n        // You can do redirects with 'redir()' or return a json or whatever \n        return true;\n    }\n\n}\n";

        file_put_contents($filePath, $template);
        echo "\nMiddleware $className creado en app/middlewares.\n";
    }
}
