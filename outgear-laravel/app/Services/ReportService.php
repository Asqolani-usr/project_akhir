<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Gear;
use App\Models\Leader;
use App\Models\Customer;

class ReportService
{
    public function generate(): array
    {
        $transactions = Transaction::with('items')->get();
        $gears = Gear::all();
        $leaders = Leader::all();
        $customers = Customer::all();

        return [
            'revenueByMonth' => $this->revenueByMonth($transactions),
            'lateFees' => $this->lateFees($transactions),
            'bestSelling' => $this->bestSelling($transactions),
            'customerActivity' => $this->customerActivity($transactions, $customers),
            'inventoryStatus' => $this->inventoryStatus($gears),
            'leaderPerformance' => $this->leaderPerformance($transactions, $leaders),
        ];
    }

    private function revenueByMonth($transactions): array
    {
        $months = [];
        foreach ($transactions as $t) {
            $key = $t->created_at->translatedFormat('M Y');
            if (!isset($months[$key])) {
                $months[$key] = ['month' => $key, 'gear_revenue' => 0, 'leader_revenue' => 0, 'total' => 0];
            }
            $months[$key]['gear_revenue'] += $t->gear_cost;
            $months[$key]['leader_revenue'] += $t->leader_cost;
            $months[$key]['total'] += $t->total_cost;
        }
        return array_values($months);
    }

    private function lateFees($transactions): array
    {
        $months = [];
        foreach ($transactions as $t) {
            if ($t->late_fee <= 0) continue;
            $key = $t->created_at->translatedFormat('M Y');
            if (!isset($months[$key])) {
                $months[$key] = ['month' => $key, 'total' => 0, 'count' => 0];
            }
            $months[$key]['total'] += $t->late_fee;
            $months[$key]['count']++;
        }
        return array_values($months);
    }

    private function bestSelling($transactions): array
    {
        $gears = [];
        foreach ($transactions as $t) {
            foreach ($t->items as $item) {
                $key = $item->gear_name;
                if (!isset($gears[$key])) {
                    $gears[$key] = ['gear_name' => $key, 'total_rented' => 0, 'revenue' => 0];
                }
                $gears[$key]['total_rented'] += $item->quantity;
                $gears[$key]['revenue'] += $item->subtotal;
            }
        }
        usort($gears, fn($a, $b) => $b['total_rented'] - $a['total_rented']);
        return array_values($gears);
    }

    private function customerActivity($transactions, $customers): array
    {
        $map = [];
        foreach ($customers as $c) {
            $map[$c->user_id] = ['customer_name' => $c->name, 'transactions' => 0, 'total_spent' => 0];
        }
        foreach ($transactions as $t) {
            if (!isset($map[$t->user_id])) {
                $map[$t->user_id] = ['customer_name' => $t->customer_name, 'transactions' => 0, 'total_spent' => 0];
            }
            $map[$t->user_id]['transactions']++;
            $map[$t->user_id]['total_spent'] += $t->total_cost;
        }
        $result = array_values($map);
        usort($result, fn($a, $b) => $b['total_spent'] - $a['total_spent']);
        return $result;
    }

    private function inventoryStatus($gears): array
    {
        $categories = [];
        foreach ($gears as $g) {
            $key = $g->category;
            if (!isset($categories[$key])) {
                $categories[$key] = ['category' => $key, 'available' => 0, 'rented' => 0, 'damaged' => 0];
            }
            if ($g->condition === 'Rusak') {
                $categories[$key]['damaged']++;
            } elseif (!$g->is_available || $g->stock <= 0) {
                $categories[$key]['rented']++;
            } else {
                $categories[$key]['available']++;
            }
        }
        return array_values($categories);
    }

    private function leaderPerformance($transactions, $leaders): array
    {
        $map = [];
        foreach ($leaders as $l) {
            $map[$l->id] = ['leader_name' => $l->name, 'assignments' => 0, 'total_fee' => 0];
        }
        foreach ($transactions as $t) {
            if (!$t->leader_id) continue;
            if (!isset($map[$t->leader_id])) {
                $map[$t->leader_id] = ['leader_name' => $t->leader_name, 'assignments' => 0, 'total_fee' => 0];
            }
            $map[$t->leader_id]['assignments']++;
            $map[$t->leader_id]['total_fee'] += $t->leader_cost;
        }
        $result = array_values($map);
        usort($result, fn($a, $b) => $b['assignments'] - $a['assignments']);
        return $result;
    }
}
