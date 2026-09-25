@extends('admin.main')

@section('admin-content')

<!-- Page Heading -->
<div class="mb-8">
    <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Welcome Back, Abdulrahman!</h1>
    <p class="text-gray-500">Here's what is happening with Al-Falah Marketing today.</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <!-- Card 1 -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase">Total Leads</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-1">1,284</h3>
            </div>
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>
        <p class="text-green-500 text-xs font-bold mt-4"><i class="fas fa-arrow-up"></i> 12% increase</p>
    </div>

    <!-- Card 2 -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase">Blog Views</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-1">45.2k</h3>
            </div>
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-chart-line text-xl"></i>
            </div>
        </div>
        <p class="text-green-500 text-xs font-bold mt-4"><i class="fas fa-arrow-up"></i> 5.4% increase</p>
    </div>

    <!-- Card 3 -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase">Active Projects</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-1">18</h3>
            </div>
            <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-tasks text-xl"></i>
            </div>
        </div>
        <p class="text-gray-400 text-xs font-bold mt-4">USA & Africa combined</p>
    </div>

    <!-- Card 4 -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase">Pending Inquiries</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-1">7</h3>
            </div>
            <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-clock text-xl"></i>
            </div>
        </div>
        <p class="text-rose-500 text-xs font-bold mt-4">Needs response today</p>
    </div>
</div>

<!-- Recent Inquiries Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-bold text-slate-800 text-lg">Recent Inquiries</h3>
        <a href="#" class="text-blue-600 text-sm font-bold hover:underline">View All</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-widest font-bold">
                    <th class="px-6 py-4">Client Name</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Region</th>
                    <th class="px-6 py-4">Service</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-semibold text-sm text-slate-700">Johnathan Reed</td>
                    <td class="px-6 py-4 text-sm text-gray-500">john@eliterealty.com</td>
                    <td class="px-6 py-4 text-sm"><span class="px-2 py-1 bg-blue-100 text-blue-600 rounded text-[10px] font-bold">USA</span></td>
                    <td class="px-6 py-4 text-sm text-gray-500">Web Design</td>
                    <td class="px-6 py-4 text-sm"><span class="px-2 py-1 bg-green-100 text-green-600 rounded text-[10px] font-bold">CONTACTED</span></td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-semibold text-sm text-slate-700">Mariama Diallo</td>
                    <td class="px-6 py-4 text-sm text-gray-500">m.diallo@payswift.ng</td>
                    <td class="px-6 py-4 text-sm"><span class="px-2 py-1 bg-amber-100 text-amber-600 rounded text-[10px] font-bold">AFRICA</span></td>
                    <td class="px-6 py-4 text-sm text-gray-500">AI Marketing</td>
                    <td class="px-6 py-4 text-sm"><span class="px-2 py-1 bg-rose-100 text-rose-600 rounded text-[10px] font-bold">PENDING</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection