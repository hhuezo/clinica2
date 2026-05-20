<ul class="main-menu">
        @can('dashboard.ver')
            <li class="slide">
                <a href="{{ route('home') }}" id="homeOption" class="side-menu__item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span class="side-menu__label">Inicio</span>
                </a>
            </li>
        @endcan

        @can('pacientes.ver')
            <li class="slide has-sub" id="pacientesMenu">
                <a href="javascript:void(0);" class="side-menu__item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.21a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                    <span class="side-menu__label">Pacientes</span>
                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1">
                    <li class="slide">
                        <a href="javascript:void(0);" id="pacientesListOption" class="side-menu__item">Listado</a>
                    </li>
                    @can('pacientes.crear')
                        <li class="slide">
                            <a href="javascript:void(0);" id="pacientesCreateOption" class="side-menu__item">Registrar paciente</a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        @can('citas.ver')
            <li class="slide has-sub" id="citasMenu">
                <a href="javascript:void(0);" class="side-menu__item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                    <span class="side-menu__label">Citas</span>
                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1">
                    <li class="slide">
                        <a href="javascript:void(0);" id="citasListOption" class="side-menu__item">Agenda</a>
                    </li>
                    @can('citas.crear')
                        <li class="slide">
                            <a href="javascript:void(0);" id="citasCreateOption" class="side-menu__item">Nueva cita</a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        @can('historiales.ver')
            <li class="slide">
                <a href="javascript:void(0);" id="historialesOption" class="side-menu__item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <span class="side-menu__label">Historiales médicos</span>
                </a>
            </li>
        @endcan

        @if (auth()->user()->can('clinicas.ver') || auth()->user()->can('sucursales.ver') || auth()->user()->can('medicos.ver') || auth()->user()->can('empresas.gestionar'))
            <li class="slide has-sub" id="organizacionMenu">
                <a href="javascript:void(0);" class="side-menu__item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h15M3 3v18" />
                    </svg>
                    <span class="side-menu__label">Organización</span>
                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1">
                    @can('empresas.gestionar')
                        <li class="slide">
                            <a href="javascript:void(0);" id="empresasOption" class="side-menu__item">Empresas</a>
                        </li>
                    @endcan
                    @can('clinicas.ver')
                        <li class="slide">
                            <a href="javascript:void(0);" id="clinicasOption" class="side-menu__item">Clínicas</a>
                        </li>
                    @endcan
                    @can('sucursales.ver')
                        <li class="slide">
                            <a href="javascript:void(0);" id="sucursalesOption" class="side-menu__item">Sucursales</a>
                        </li>
                    @endcan
                    @can('medicos.ver')
                        <li class="slide">
                            <a href="javascript:void(0);" id="medicosOption" class="side-menu__item">Médicos</a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endif

        @if (auth()->user()->can('usuarios.gestionar') || auth()->user()->can('roles.gestionar'))
            <li class="slide has-sub" id="seguridadMenu">
                <a href="javascript:void(0);" class="side-menu__item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                    <span class="side-menu__label">Seguridad</span>
                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1">
                    @can('usuarios.gestionar')
                        <li class="slide">
                            <a href="javascript:void(0);" id="usuariosOption" class="side-menu__item">Usuarios</a>
                        </li>
                    @endcan
                    @can('roles.gestionar')
                        <li class="slide">
                            <a href="javascript:void(0);" id="rolesOption" class="side-menu__item">Roles</a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endif

        @if (auth()->user()->can('reportes.pdf') || auth()->user()->can('reportes.excel'))
            <li class="slide has-sub" id="reportesMenu">
                <a href="javascript:void(0);" class="side-menu__item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                    </svg>
                    <span class="side-menu__label">Reportes</span>
                    <i class="ri-arrow-down-s-line side-menu__angle"></i>
                </a>
                <ul class="slide-menu child1">
                    @can('reportes.pdf')
                        <li class="slide">
                            <a href="javascript:void(0);" id="reportesPdfOption" class="side-menu__item">Exportar PDF</a>
                        </li>
                    @endcan
                    @can('reportes.excel')
                        <li class="slide">
                            <a href="javascript:void(0);" id="reportesExcelOption" class="side-menu__item">Exportar Excel</a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endif
</ul>
