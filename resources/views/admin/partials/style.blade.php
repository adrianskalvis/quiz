<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
        font-family: sans-serif; min-height: 100vh;
        background: url('/images/welcomebg.jpg') center/cover no-repeat fixed;
    }
    body::before {
        content: ''; position: fixed; inset: 0;
        background: rgba(5,18,32,0.6); z-index: 0;
    }
    .admin-page {
        position: relative; z-index: 1;
        display: flex; min-height: 100vh; padding-top: 52px;
    }
    .sidebar {
        width: 210px; flex-shrink: 0;
        background: rgba(255,255,255,0.05);
        border-right: 0.5px solid rgba(255,255,255,0.1);
        backdrop-filter: blur(16px);
        padding: 24px 0;
        position: sticky; top: 52px; height: calc(100vh - 52px);
        display: flex; flex-direction: column;
    }
    .sidebar-title {
        color: rgba(255,255,255,0.3); font-size: 10px;
        text-transform: uppercase; letter-spacing: 0.1em;
        padding: 0 20px 12px;
    }
    .sidebar a {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 20px; color: rgba(255,255,255,0.6);
        font-size: 13px; text-decoration: none;
        transition: all .2s; border-left: 2px solid transparent;
    }
    .sidebar a:hover, .sidebar a.active {
        background: rgba(255,255,255,0.07);
        color: #fff; border-left-color: rgba(100,190,255,0.8);
    }
    .sidebar .back-link {
        margin-top: auto;
        border-top: 0.5px solid rgba(255,255,255,0.08);
    }
    .s-icon { font-size: 15px; }
    .admin-main { flex: 1; padding: 32px 36px; overflow-y: auto; }
    .admin-header { margin-bottom: 28px; }
    .admin-header h1 {
        color: #fff; font-size: 24px; font-weight: 500;
        text-shadow: 0 0 40px rgba(140,210,255,0.4);
    }
    .admin-header p { color: rgba(255,255,255,0.4); font-size: 13px; margin-top: 3px; }
    .flash {
        padding: 11px 16px; border-radius: 10px;
        font-size: 13px; margin-bottom: 20px; border: 0.5px solid;
    }
    .flash-success { background: rgba(40,180,90,0.12); color: rgba(80,220,130,0.9); border-color: rgba(40,180,90,0.25); }
    .flash-error   { background: rgba(200,50,30,0.12); color: rgba(255,100,80,0.9);  border-color: rgba(200,50,30,0.25); }
    .acard {
        background: rgba(255,255,255,0.06);
        border: 0.5px solid rgba(255,255,255,0.12);
        border-radius: 16px; backdrop-filter: blur(16px);
        overflow: hidden; margin-bottom: 20px;
    }
    .acard-header {
        padding: 16px 20px;
        border-bottom: 0.5px solid rgba(255,255,255,0.08);
        display: flex; align-items: center; justify-content: space-between;
    }
    .acard-header h2 { color: #fff; font-size: 15px; font-weight: 500; }
    .atable { width: 100%; border-collapse: collapse; }
    .atable thead th {
        color: rgba(255,255,255,0.35); font-size: 10px;
        text-transform: uppercase; letter-spacing: 0.08em;
        padding: 10px 16px; text-align: left;
        border-bottom: 0.5px solid rgba(255,255,255,0.08);
    }
    .atable tbody tr { border-bottom: 0.5px solid rgba(255,255,255,0.05); transition: background .15s; }
    .atable tbody tr:hover { background: rgba(255,255,255,0.04); }
    .atable tbody tr:last-child { border-bottom: none; }
    .atable tbody td { padding: 12px 16px; color: rgba(255,255,255,0.75); font-size: 13px; }
    .btn-primary {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px; border-radius: 10px; font-size: 13px;
        font-weight: 500; color: #fff; text-decoration: none;
        border: none; cursor: pointer; font-family: inherit;
        background: linear-gradient(180deg, rgba(100,190,255,0.9) 0%, rgba(40,130,230,1) 40%, rgba(20,100,210,1) 60%, rgba(60,150,255,0.9) 100%);
        box-shadow: 0 0 0 1px rgba(120,200,255,0.3), 0 3px 12px rgba(40,120,220,0.3), inset 0 1px 0 rgba(255,255,255,0.25);
        transition: all .2s;
    }
    .btn-primary:hover { transform: translateY(-1px); }
    .btn-danger {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 12px; border-radius: 8px; font-size: 12px;
        color: rgba(255,100,80,0.9); border: 0.5px solid rgba(200,50,30,0.3);
        background: rgba(200,50,30,0.1); cursor: pointer; font-family: inherit;
        transition: all .2s; text-decoration: none;
    }
    .btn-danger:hover { background: rgba(200,50,30,0.2); color: #ff7060; }
    .btn-edit {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 6px 12px; border-radius: 8px; font-size: 12px;
        color: rgba(255,255,255,0.6); border: 0.5px solid rgba(255,255,255,0.15);
        background: rgba(255,255,255,0.07); cursor: pointer; font-family: inherit;
        transition: all .2s; text-decoration: none;
    }
    .btn-edit:hover { background: rgba(255,255,255,0.13); color: #fff; }
    .form-group { margin-bottom: 18px; }
    .form-label { display: block; color: rgba(255,255,255,0.6); font-size: 12px; margin-bottom: 6px; }
    .form-input, .form-select, .form-textarea {
        width: 100%; padding: 10px 14px;
        background: rgba(255,255,255,0.07);
        border: 0.5px solid rgba(255,255,255,0.15);
        border-radius: 10px; color: #fff; font-size: 13px;
        font-family: inherit; outline: none; transition: border-color .2s;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus { border-color: rgba(100,190,255,0.5); }
    .form-textarea { resize: vertical; min-height: 80px; }
    .form-select option { background: #1a3a5c; color: #fff; }
    .stats-grid {
        display: grid; grid-template-columns: repeat(4, 1fr);
        gap: 14px; margin-bottom: 28px;
    }
    .stat-card {
        background: rgba(255,255,255,0.06);
        border: 0.5px solid rgba(255,255,255,0.12);
        border-radius: 14px; padding: 20px;
        text-align: center; backdrop-filter: blur(12px);
    }
    .stat-icon { font-size: 26px; margin-bottom: 8px; }
    .stat-val  { color: #fff; font-size: 28px; font-weight: 500; text-shadow: 0 0 20px rgba(140,210,255,0.4); }
    .stat-lbl  { color: rgba(255,255,255,0.4); font-size: 12px; margin-top: 3px; }
    .quick-links { display: flex; gap: 12px; flex-wrap: wrap; }
    .ql-btn {
        padding: 10px 20px; border-radius: 12px; font-size: 13px;
        color: rgba(255,255,255,0.7); text-decoration: none;
        border: 0.5px solid rgba(255,255,255,0.15);
        background: rgba(255,255,255,0.07); transition: all .2s;
    }
    .ql-btn:hover { background: rgba(255,255,255,0.13); color: #fff; }
    .drop-zone {
        border: 1.5px dashed rgba(255,255,255,0.2);
        border-radius: 12px; padding: 28px;
        text-align: center; cursor: pointer;
        transition: all .2s; background: rgba(255,255,255,0.04);
    }
    .drop-zone:hover, .drop-zone.dragover {
        border-color: rgba(100,190,255,0.5);
        background: rgba(80,160,255,0.08);
    }
    .drop-zone-icon { font-size: 28px; margin-bottom: 8px; }
    .drop-zone p { color: rgba(255,255,255,0.4); font-size: 12px; margin-top: 4px; }
    .drop-zone strong { color: rgba(255,255,255,0.7); }
    .drop-preview { max-width: 120px; max-height: 80px; border-radius: 8px; margin: 10px auto 0; display: none; }
    .answer-row { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
    .answer-radio { flex-shrink: 0; accent-color: #50b4ff; cursor: pointer; width: 16px; height: 16px; }
    .answer-input { flex: 1; }
    .correct-hint { color: rgba(255,255,255,0.3); font-size: 11px; }
    .add-answer-btn {
        background: none; border: 0.5px dashed rgba(255,255,255,0.2);
        color: rgba(255,255,255,0.4); padding: 8px; border-radius: 8px;
        cursor: pointer; font-size: 12px; width: 100%;
        transition: all .2s; font-family: inherit; margin-top: 4px;
    }
    .add-answer-btn:hover { border-color: rgba(255,255,255,0.4); color: rgba(255,255,255,0.7); }
    .role-badge { font-size: 10px; padding: 2px 8px; border-radius: 99px; }
    .role-admin { background: rgba(255,200,60,0.15); color: rgba(255,210,80,0.9); border: 0.5px solid rgba(255,200,60,0.3); }
    .role-user  { background: rgba(80,160,255,0.12); color: rgba(120,190,255,0.8); border: 0.5px solid rgba(80,160,255,0.25); }
</style>
