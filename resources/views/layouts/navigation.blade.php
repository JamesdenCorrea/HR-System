<nav style="background:linear-gradient(135deg,#0f172a 0%,#1e1b4b 50%,#312e81 100%);box-shadow:0 2px 16px rgba(15,23,42,0.5);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- Left: Logo + Nav Links --}}
            <div class="flex items-center gap-4">

                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3" style="text-decoration:none;">
                    <img src="{{ asset('logo.png') }}"
                         alt="Logo"
                         style="height:38px;width:auto;object-fit:contain;filter:brightness(1.1);">
                    <span style="color:white;font-weight:700;font-size:14px;white-space:nowrap;letter-spacing:0.2px;">
                        HR Management System
                    </span>
                </a>

                {{-- Divider --}}
                <div style="width:1px;height:28px;background:rgba(255,255,255,0.2);margin:0 4px;"></div>

                {{-- Nav Links --}}
                <div class="hidden sm:flex items-center gap-1">

                    <a href="{{ route('dashboard') }}" style="padding:6px 11px;border-radius:6px;font-size:12.5px;font-weight:500;color:rgba(255,255,255,0.85);text-decoration:none;transition:all 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.12)';this.style.color='white'"
                       onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.85)'">
                        Dashboard
                    </a>

                    @hasanyrole('admin|hr')
                    <a href="{{ route('hr.employees.index') }}" style="padding:6px 11px;border-radius:6px;font-size:12.5px;font-weight:500;color:rgba(255,255,255,0.85);text-decoration:none;transition:all 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.12)';this.style.color='white'"
                       onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.85)'">
                        Employees
                    </a>
                    @endhasanyrole

                    <a href="{{ route('attendance.clock') }}" style="padding:6px 11px;border-radius:6px;font-size:12.5px;font-weight:500;color:rgba(255,255,255,0.85);text-decoration:none;transition:all 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.12)';this.style.color='white'"
                       onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.85)'">
                        My Attendance
                    </a>

                    @hasrole('hr')
                    <a href="{{ route('hr.attendance.index') }}" style="padding:6px 11px;border-radius:6px;font-size:12.5px;font-weight:500;color:rgba(255,255,255,0.85);text-decoration:none;transition:all 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.12)';this.style.color='white'"
                       onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.85)'">
                        Attendance
                    </a>
                    @endhasrole

                    <a href="{{ route('leaves.my') }}" style="padding:6px 11px;border-radius:6px;font-size:12.5px;font-weight:500;color:rgba(255,255,255,0.85);text-decoration:none;transition:all 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.12)';this.style.color='white'"
                       onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.85)'">
                        My Leaves
                    </a>

                    @hasrole('hr')
                    <a href="{{ route('hr.leaves.index') }}" style="padding:6px 11px;border-radius:6px;font-size:12.5px;font-weight:500;color:rgba(255,255,255,0.85);text-decoration:none;transition:all 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.12)';this.style.color='white'"
                       onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.85)'">
                        Leaves
                    </a>
                    @endhasrole

                    @hasanyrole('admin|hr')
                    <a href="{{ route('account-requests.index') }}" style="padding:6px 11px;border-radius:6px;font-size:12.5px;font-weight:500;color:rgba(255,255,255,0.85);text-decoration:none;transition:all 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.12)';this.style.color='white'"
                       onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.85)'">
                        Account Requests
                    </a>
                    @endhasanyrole

                    @hasrole('admin')
                    <a href="{{ route('admin.account-requests.index') }}" style="padding:6px 11px;border-radius:6px;font-size:12.5px;font-weight:500;color:rgba(255,255,255,0.85);text-decoration:none;transition:all 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.12)';this.style.color='white'"
                       onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.85)'">
                        Manage Accounts
                    </a>
                    @endhasrole

                    @hasrole('hr')
                    <a href="{{ route('hr.payroll.index') }}" style="padding:6px 11px;border-radius:6px;font-size:12.5px;font-weight:500;color:rgba(255,255,255,0.85);text-decoration:none;transition:all 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.12)';this.style.color='white'"
                       onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.85)'">
                        Payroll
                    </a>
                    @endhasrole

                    <a href="{{ route('payroll.my-payslips') }}" style="padding:6px 11px;border-radius:6px;font-size:12.5px;font-weight:500;color:rgba(255,255,255,0.85);text-decoration:none;transition:all 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.12)';this.style.color='white'"
                       onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.85)'">
                        My Payslips
                    </a>

                    @hasrole('hr')
                    <a href="{{ route('hr.reports.index') }}" style="padding:6px 11px;border-radius:6px;font-size:12.5px;font-weight:500;color:rgba(255,255,255,0.85);text-decoration:none;transition:all 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.12)';this.style.color='white'"
                       onmouseout="this.style.background='transparent';this.style.color='rgba(255,255,255,0.85)'">
                        Reports
                    </a>
                    @endhasrole

                </div>
            </div>

            {{-- Right: User dropdown --}}
            <div class="flex items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button style="display:flex;align-items:center;gap:8px;padding:7px 14px;border-radius:8px;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.2);color:white;font-size:13px;font-weight:500;cursor:pointer;transition:background 0.2s;"
                            onmouseover="this.style.background='rgba(255,255,255,0.18)'"
                            onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                            <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#4f46e5,#7c3aed);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:white;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span>{{ auth()->user()->name }}</span>
                            <svg style="width:14px;height:14px;opacity:0.7;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div style="padding:8px 16px;border-bottom:1px solid #f3f4f6;margin-bottom:4px;">
                            <p style="font-size:12px;color:#6b7280;margin:0;">Signed in as</p>
                            <p style="font-size:13px;font-weight:600;color:#111827;margin:2px 0 0;">{{ auth()->user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile Settings
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

        </div>
    </div>
</nav>