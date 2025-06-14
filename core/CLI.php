<?php
namespace Core;

class CLI
{
    public function handle($command, $args)
    {
        switch ($command) {
            case 'c':
                $this->makeController($args[0] ?? null);
                break;
            case 'm':
                $this->makeModel($args[0] ?? null);
                break;
            case 's':
                $this->makeService($args[0] ?? null);
                break;
            case 'mi':
                $this->makeMiddleware($args[0] ?? null);
                break;
            case 'full':
                $this->makeModel($args[0] ?? null);
                $this->makeService($args[0] ?? null);
                $this->makeController($args[0] ?? null);
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

        $template = "<?php \n\nnamespace App\\Controllers;\n\nuse Core\\Controller;\nuse Core\\Request;\n\nclass {$className} extends Controller {\n\n    public function __construct(){\n\n    }\n    \n    public function index(Request \$req){\n\n    }\n\n}\n\n?>";

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
        $template = "<?php \n\nnamespace App\\Models;\n\nuse Core\\Databases\\DB;\n\nclass {$className} {\n\n    public function list(){\n        \$db = DB::init();\n        return \$db->db_select(\"SELECT * FROM {$tableName}\", null);\n    }\n\n}\n";

        file_put_contents($filePath, $template);
        echo "\nModelo $className creado en app/models.\n";
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
            $requiere_model = "require_once './app/models/" .ucfirst($name) . ".php';\n\n"; 
            $use_model = "use App\\Models\\" . ucfirst($name) . ";\n\n";
        }else{
            $requiere_model = "";
            $use_model = "";
        }

        $template = "<?php \n\nnamespace App\\Services;\n\n{$requiere_model}{$use_model}class {$className} {\n\n\n}\n";

        file_put_contents($filePath, $template);
        echo "\nServicio $className creado en app/services.\n";
    }


}
