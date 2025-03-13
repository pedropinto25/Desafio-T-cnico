<?php
use PHPUnit\Framework\TestCase;
use App\Controllers\UserController;
use App\Models\UserModel;

class UserControllerTest extends TestCase {
    private $controller;

    protected function setUp(): void {
        $this->controller = new UserController();
        echo "Setup completo: UserController inicializado.\n";
    }

    public function testRegisterUser() {
        $name = "Test User";
        $email = "testuser4@example.com";
        $password = "password123";
        $role = "admin";

        echo "Iniciando teste de registro de usuário...\n";
        echo "Dados do utilizador: Nome = $name, Email = $email, Senha = $password, Role = $role\n";

        $result = $this->controller->registerUser($name, $email, $password, $role);
        echo "Resultado do registo: " . ($result ? "Sucesso" : "Falha") . "\n";

        $this->assertTrue($result);

        // Verifica se o utilizador foi registado corretamente
        $userModel = new UserModel();
        $user = $userModel->getUserByEmail($email);

        echo "Dados do utilizador registado: " . print_r($user, true) . "\n";

        $this->assertNotNull($user);
        $this->assertEquals($name, $user['name']);
        $this->assertEquals($email, $user['email']);

        echo "Teste de registo do utilizador concluído com sucesso.\n";
    }

    protected function tearDown(): void {
        echo "Fim do Teste...\n";
        parent::tearDown();
    }
}