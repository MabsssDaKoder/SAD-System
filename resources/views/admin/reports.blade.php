@extends('admin.admin-layout')

@section('title', 'Reports')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/reports.css') }}">
@endsection

@section('content')

<div class="page-title">Reports</div>

<div class="reports-card">

    {{-- Tabs --}}
    <div class="report-tabs">
        <button class="tab-btn active" onclick="showTab('daily', this)">Daily</button>
        <button class="tab-btn" onclick="showTab('weekly', this)">Weekly</button>
        <button class="tab-btn" onclick="showTab('monthly', this)">Monthly</button>
        <button class="tab-btn" onclick="showTab('annually', this)">Annually</button>
    </div>

    {{-- ==================== DAILY TAB ==================== --}}
    <div class="tab-content" id="tab-daily">

        {{-- Summary Cards --}}
        <div class="summary-cards">
            <div class="summary-card">
                <p class="summary-label">Total Customer Served</p>
                {{-- VARIABLE: daily_total_customers --}}
                <h2 class="summary-value">101</h2>
                <small class="summary-sub">Increase 15 customer today</small>
            </div>
            <div class="summary-card">
                <p class="summary-label">Total Revenue Today</p>
                {{-- VARIABLE: daily_total_revenue --}}
                <h2 class="summary-value">₱15,000</h2>
                <small class="summary-sub">Increase by 20%</small>
            </div>
            <div class="summary-card">
                <p class="summary-label">Most use Addons</p>
                {{-- VARIABLE: daily_most_used_addon --}}
                <h2 class="summary-value addon-value">Tide & Downy</h2>
            </div>
        </div>

        {{-- Charts Row --}}
        <div class="charts-row">

            {{-- Most Washed Color --}}
            <div class="chart-card">
                <h3 class="chart-title">Most Washed Color</h3>
                <div class="pie-chart-wrapper">
                    <canvas id="daily-color-chart"></canvas>
                    <div class="pie-legend">
                        {{-- VARIABLE: daily_color_stats --}}
                        <div class="legend-item"><span class="dot white"></span> 50% White Clothes</div>
                        <div class="legend-item"><span class="dot black"></span> 35% Black Clothes</div>
                        <div class="legend-item"><span class="dot colored"></span> 5% Colored Clothes</div>
                        <div class="legend-item"><span class="dot others"></span> 10% Others</div>
                    </div>
                </div>
            </div>

            {{-- High Spend Customer --}}
            <div class="chart-card">
                <h3 class="chart-title">High Spend Customer</h3>
                <div class="customer-list">
                    {{-- VARIABLE: daily_high_spend_customers --}}
                    <div class="customer-item active">
                        <span class="rank">1.</span>
                        <span class="cname">Don Don Magpantay</span>
                        <span class="amount">₱5,000</span>
                    </div>
                    <div class="customer-item">
                        <span class="rank">2.</span>
                        <span class="cname">Lee Bug</span>
                        <span class="amount">₱3,500</span>
                    </div>
                    <div class="customer-item">
                        <span class="rank">3.</span>
                        <span class="cname">Justin Karl</span>
                        <span class="amount">₱2,000</span>
                    </div>
                    <div class="customer-item">
                        <span class="rank">4.</span>
                        <span class="cname">Jiji Jojo</span>
                        <span class="amount">₱1,000</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- Service Receive Breakdown --}}
        <div class="breakdown-card">
            <h3 class="chart-title">Service Receive Breakdown</h3>
            <div class="breakdown-row">
                <div class="breakdown-item">
                    <p>Ordinary</p>
                    {{-- VARIABLE: daily_ordinary_count --}}
                    <h2>60</h2>
                </div>
                <div class="breakdown-item">
                    <p>Rush</p>
                    {{-- VARIABLE: daily_rush_count --}}
                    <h2>41</h2>
                </div>
            </div>
        </div>

    </div>

    {{-- ==================== WEEKLY TAB ==================== --}}
    <div class="tab-content hidden" id="tab-weekly">

        <div class="summary-cards">
            <div class="summary-card">
                <p class="summary-label">Total Customer Served This Week</p>
                {{-- VARIABLE: weekly_total_customers --}}
                <h2 class="summary-value">500</h2>
                <small class="summary-sub">Increase customer</small>
            </div>
            <div class="summary-card">
                <p class="summary-label">Total Revenue this Week</p>
                {{-- VARIABLE: weekly_total_revenue --}}
                <h2 class="summary-value">₱50,000</h2>
                <small class="summary-sub">Increase by 20%</small>
            </div>
            <div class="summary-card">
                <p class="summary-label">Most use Addons</p>
                {{-- VARIABLE: weekly_most_used_addon --}}
                <h2 class="summary-value addon-value">Surf & Lenor</h2>
            </div>
        </div>

        <div class="charts-row">
            <div class="chart-card">
                <h3 class="chart-title">Most Washed Color</h3>
                <div class="pie-chart-wrapper">
                    <canvas id="weekly-color-chart"></canvas>
                    <div class="pie-legend">
                        {{-- VARIABLE: weekly_color_stats --}}
                        <div class="legend-item"><span class="dot white"></span> 50% White Clothes</div>
                        <div class="legend-item"><span class="dot black"></span> 25% Black Clothes</div>
                        <div class="legend-item"><span class="dot colored"></span> 15% Colored Clothes</div>
                        <div class="legend-item"><span class="dot others"></span> 10% Others</div>
                    </div>
                </div>
            </div>

            <div class="chart-card">
                <h3 class="chart-title">Most Frequent Customer</h3>
                <div class="customer-list">
                    {{-- VARIABLE: weekly_frequent_customers --}}
                    <div class="customer-item active">
                        <span class="rank">1.</span>
                        <span class="cname">Don Don Magpantay</span>
                        <span class="amount">₱5,000</span>
                    </div>
                    <div class="customer-item">
                        <span class="rank">2.</span>
                        <span class="cname">Lee Bug</span>
                        <span class="amount">₱3,500</span>
                    </div>
                    <div class="customer-item">
                        <span class="rank">3.</span>
                        <span class="cname">Justin Karl</span>
                        <span class="amount">₱2,000</span>
                    </div>
                    <div class="customer-item">
                        <span class="rank">4.</span>
                        <span class="cname">Jiji Jojo</span>
                        <span class="amount">₱1,000</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="breakdown-card">
            <h3 class="chart-title">Service Receive Breakdown</h3>
            <div class="breakdown-row">
                <div class="breakdown-item">
                    <p>Ordinary</p>
                    {{-- VARIABLE: weekly_ordinary_count --}}
                    <h2>340</h2>
                </div>
                <div class="breakdown-item">
                    <p>Rush</p>
                    {{-- VARIABLE: weekly_rush_count --}}
                    <h2>160</h2>
                </div>
            </div>
        </div>

    </div>

    {{-- ==================== MONTHLY TAB ==================== --}}
    <div class="tab-content hidden" id="tab-monthly">

        <div class="summary-cards">
            <div class="summary-card">
                <p class="summary-label">Total Customer Served This Month</p>
                {{-- VARIABLE: monthly_total_customers --}}
                <h2 class="summary-value">2,100</h2>
                <small class="summary-sub">Increase customer</small>
            </div>
            <div class="summary-card">
                <p class="summary-label">Total Revenue this Month</p>
                {{-- VARIABLE: monthly_total_revenue --}}
                <h2 class="summary-value">₱210,000</h2>
                <small class="summary-sub">Increase by 15%</small>
            </div>
            <div class="summary-card">
                <p class="summary-label">Most use Addons</p>
                {{-- VARIABLE: monthly_most_used_addon --}}
                <h2 class="summary-value addon-value">Tide & Lenor</h2>
            </div>
        </div>

        <div class="charts-row">
            <div class="chart-card">
                <h3 class="chart-title">Most Washed Color</h3>
                <div class="pie-chart-wrapper">
                    <canvas id="monthly-color-chart"></canvas>
                    <div class="pie-legend">
                        {{-- VARIABLE: monthly_color_stats --}}
                        <div class="legend-item"><span class="dot white"></span> 45% White Clothes</div>
                        <div class="legend-item"><span class="dot black"></span> 30% Black Clothes</div>
                        <div class="legend-item"><span class="dot colored"></span> 15% Colored Clothes</div>
                        <div class="legend-item"><span class="dot others"></span> 10% Others</div>
                    </div>
                </div>
            </div>

            <div class="chart-card">
                <h3 class="chart-title">Most Frequent Customer</h3>
                <div class="customer-list">
                    {{-- VARIABLE: monthly_frequent_customers --}}
                    <div class="customer-item active">
                        <span class="rank">1.</span>
                        <span class="cname">Don Don Magpantay</span>
                        <span class="amount">₱20,000</span>
                    </div>
                    <div class="customer-item">
                        <span class="rank">2.</span>
                        <span class="cname">Lee Bug</span>
                        <span class="amount">₱15,000</span>
                    </div>
                    <div class="customer-item">
                        <span class="rank">3.</span>
                        <span class="cname">Justin Karl</span>
                        <span class="amount">₱10,000</span>
                    </div>
                    <div class="customer-item">
                        <span class="rank">4.</span>
                        <span class="cname">Jiji Jojo</span>
                        <span class="amount">₱5,000</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="breakdown-card">
            <h3 class="chart-title">Service Receive Breakdown</h3>
            <div class="breakdown-row">
                <div class="breakdown-item">
                    <p>Ordinary</p>
                    {{-- VARIABLE: monthly_ordinary_count --}}
                    <h2>1,400</h2>
                </div>
                <div class="breakdown-item">
                    <p>Rush</p>
                    {{-- VARIABLE: monthly_rush_count --}}
                    <h2>700</h2>
                </div>
            </div>
        </div>

    </div>

    {{-- ==================== ANNUALLY TAB ==================== --}}
    <div class="tab-content hidden" id="tab-annually">

        <div class="summary-cards">
            <div class="summary-card">
                <p class="summary-label">Total Customer Served This Year</p>
                {{-- VARIABLE: annual_total_customers --}}
                <h2 class="summary-value">25,000</h2>
                <small class="summary-sub">Increase customer</small>
            </div>
            <div class="summary-card">
                <p class="summary-label">Total Revenue this Year</p>
                {{-- VARIABLE: annual_total_revenue --}}
                <h2 class="summary-value">₱2,500,000</h2>
                <small class="summary-sub">Increase by 10%</small>
            </div>
            <div class="summary-card">
                <p class="summary-label">Most use Addons</p>
                {{-- VARIABLE: annual_most_used_addon --}}
                <h2 class="summary-value addon-value">Downy & Surf</h2>
            </div>
        </div>

        <div class="charts-row">
            <div class="chart-card">
                <h3 class="chart-title">Most Washed Color</h3>
                <div class="pie-chart-wrapper">
                    <canvas id="annually-color-chart"></canvas>
                    <div class="pie-legend">
                        {{-- VARIABLE: annual_color_stats --}}
                        <div class="legend-item"><span class="dot white"></span> 48% White Clothes</div>
                        <div class="legend-item"><span class="dot black"></span> 28% Black Clothes</div>
                        <div class="legend-item"><span class="dot colored"></span> 14% Colored Clothes</div>
                        <div class="legend-item"><span class="dot others"></span> 10% Others</div>
                    </div>
                </div>
            </div>

            <div class="chart-card">
                <h3 class="chart-title">Most Frequent Customer</h3>
                <div class="customer-list">
                    {{-- VARIABLE: annual_frequent_customers --}}
                    <div class="customer-item active">
                        <span class="rank">1.</span>
                        <span class="cname">Don Don Magpantay</span>
                        <span class="amount">₱250,000</span>
                    </div>
                    <div class="customer-item">
                        <span class="rank">2.</span>
                        <span class="cname">Lee Bug</span>
                        <span class="amount">₱180,000</span>
                    </div>
                    <div class="customer-item">
                        <span class="rank">3.</span>
                        <span class="cname">Justin Karl</span>
                        <span class="amount">₱120,000</span>
                    </div>
                    <div class="customer-item">
                        <span class="rank">4.</span>
                        <span class="cname">Jiji Jojo</span>
                        <span class="amount">₱80,000</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="breakdown-card">
            <h3 class="chart-title">Service Receive Breakdown</h3>
            <div class="breakdown-row">
                <div class="breakdown-item">
                    <p>Ordinary</p>
                    {{-- VARIABLE: annual_ordinary_count --}}
                    <h2>17,000</h2>
                </div>
                <div class="breakdown-item">
                    <p>Rush</p>
                    {{-- VARIABLE: annual_rush_count --}}
                    <h2>8,000</h2>
                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/admin/reports.js') }}"></script>
@endsection