<?php

namespace Tests\Unit;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_task()
    {
        $data = [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'status' => 'pending',
            'due_date' => '2024-12-31',
        ];

        $this->postJson('/api/tasks', $data)
            ->assertStatus(201)
            ->assertJson($data);
    }

    // Añadir pruebas adicionales para leer, actualizar y eliminar tareas...
}
