<?php

namespace App\Repositories\SubscriptionPlan;

interface SubscriptionPlanInterface
{

    public function all(?bool $status = null, ?int $paginate = null, string $orderBy = 'id', $sortBy = 'desc');

    public function first($id);

    public function store($request);

    public function update($id, $request);

    public function delete($id);
}
