<?php

namespace Spinen\ClickUp;

use Carbon\Carbon;
use Spinen\ClickUp\Exceptions\InvalidRelationshipException;
use Spinen\ClickUp\Exceptions\ModelNotFoundException;
use Spinen\ClickUp\Exceptions\NoClientException;
use Spinen\ClickUp\Support\Model;
use Spinen\ClickUp\Support\Relations\ChildOf;

/**
 * Class Comment
 *
 * @property array $comments
 * @property array $relations
 * @property bool $resolved
 * @property Carbon $date
 * @property int $id
 * @property Member $assigned_by
 * @property Member $assignee
 * @property Member $user
 * @property string $hist_id
 * @property string $text
 * @property Task|null $task
 * @property TasksList|null $list
 * @property View|null $view
 */
class Comment extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime:Uv',
        'id' => 'integer',
        'resolved' => 'boolean',
    ];

    /**
     * Path to API endpoint.
     */
    protected string $path = '/comment';

    /**
     * Accessor for Assignee.
     *
     * @throws NoClientException
     */
    public function getAssigneeAttribute(?array $assignee): Member
    {
        return $this->givenOne(Member::class, $assignee);
    }

    /**
     * Accessor for AssignedBy.
     *
     * @throws NoClientException
     */
    public function getAssignedByAttribute(?array $assigned_by): Member
    {
        return $this->givenOne(Member::class, $assigned_by);
    }

    /**
     * Accessor for User.
     *
     * @throws NoClientException
     */
    public function getUserAttribute(?array $user): Member
    {
        return $this->givenOne(Member::class, $user);
    }

    /**
     * Optional Child of TaskList
     *
     * @throws InvalidRelationshipException
     * @throws ModelNotFoundException
     * @throws NoClientException
     */
    public function list(): ?ChildOf
    {
        return is_a($this->parentModel, TaskList::class) ? $this->childOf(TaskList::class) : null;
    }

    /**
     * Child of Task
     *
     * @throws InvalidRelationshipException
     * @throws ModelNotFoundException
     * @throws NoClientException
     */
    public function task(): ?ChildOf
    {
        return is_a($this->parentModel, Task::class) ? $this->childOf(Task::class) : null;
    }

    /**
     * Child of View
     *
     * @throws InvalidRelationshipException
     * @throws ModelNotFoundException
     * @throws NoClientException
     */
    public function view(): ?ChildOf
    {
        return is_a($this->parentModel, View::class) ? $this->childOf(View::class) : null;
    }
}
