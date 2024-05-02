<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        @if (Auth::user()->role == 1)
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('Scan-Dokumen') ? '' : 'collapsed' }}"
                href="{{ route('Scan-Dokumen') }}">
                <i class="bi bi-journal-text"></i>
                <span>Surat Permohonan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('Scan-KTP') ? '' : 'collapsed' }}" href="{{ url('Scan-KTP') }}">
                <i class="bi bi-journal-text"></i>
                <span>Data KTP</span>
            </a>
        </li>
        @endif
    </ul>

</aside><!-- End Sidebar-->
