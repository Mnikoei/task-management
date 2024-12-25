<?php


use App\Services\Task\Models\Enums\TaskStatus;
use App\Services\Task\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class TasksFetchTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

//    public function testValidatesInput()
//    {
//        $this->assertTrue(false);
//    }

    public function testCanGetTasksListWithCorrectCount(): void
    {
        $user = $this->authenticatedUser();

        $tasks = Task::factory()->count(30)->for($user)->create();

        $response = $this->getJson(
            '/api/v1/task?' . $this->getEncodedQueryStringFilters([]));


        $response->assertJsonCount(30);
    }

    public function testGetsJustHisOwnTasks(): void
    {
        $user = $this->authenticatedUser();
        $anotherUser = $this->user();

        Task::factory()->count(10)->for($user)->create();
        Task::factory()->count(5)->for($anotherUser)->create();

        $response = $this->getJson(
            '/api/v1/task?' . $this->getEncodedQueryStringFilters([]));


        $response->assertJsonCount(10);
    }

    #[DataProvider('filterDataProvider')]
    public function testCanFilterTasks($filter, $savedValue, $search): void
    {
        $user = $this->authenticatedUser();

        Task::factory()->count(5)->for($user)->create([$filter => $savedValue]);

        Task::factory()->count(2)->for($user)->create();

        $response = $this->getJson(
            '/api/v1/task?' . $this->getEncodedQueryStringFilters([$filter => $search]));

        $response->assertJsonCount(5);
    }

    public function getEncodedQueryStringFilters(array $params): string
    {
        return http_build_query([
            'filters' => base64_encode(json_encode($params))
        ]);
    }


    public static function filterDataProvider(): array
    {
        date_default_timezone_set("Asia/Tehran");

        return [
            ['title', 'Be strong man', 'strong'],
            ['description', 'Hello what a beautiful day', 'beautiful'],
            ['due_date', date("Y-m-d H:i:s", strtotime("+1 minute")), date("Y-m-d H:i:s", strtotime("+2 minute"))],
            ['status', TaskStatus::COMPLETED->value, TaskStatus::COMPLETED->value],
        ];
    }
}
