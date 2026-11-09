<style>
    .kartu {
        background: #fff;
        border-radius: 8px;
        padding: 24px;
        max-width: 560px;
    }

    .kartu label {
        display: block;
        margin: 12px 0 4px;
        font-weight: 700;
    }

    .kartu input,
    .kartu select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 16px;
    }

    .kartu .btn {
        margin-top: 16px;
        border: 0;
        cursor: pointer;
        font-size: 16px;
    }

    .pesan-error {
        color: #dc2626;
        font-size: 14px;
        margin-top: 4px;
    }
</style>

<div class="kartu">
    <form method="POST" action="{{ $action }}">
        @csrf
        @if (isset($user)) @method('PUT') @endif

        <label for="name">Nama</label>
        <input id="name" type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required>
        @error('name') <div class="pesan-error">{{ $message }}</div> @enderror

        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
        @error('email') <div class="pesan-error">{{ $message }}</div> @enderror

        @unless (isset($user))
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
        @error('password') <div class="pesan-error">{{ $message }}</div> @enderror
        @endunless

        <label for="role">Role</label>
        <select id="role" name="role" required>
            @foreach ($roles as $r)
            <option value="{{ $r }}" @selected(old('role', isset($user) ? $user->roles->first()?->name : 'siswa') === $r)>
                {{ ucfirst($r) }}
            </option>
            @endforeach
        </select>
        @error('role') <div class="pesan-error">{{ $message }}</div> @enderror

        <button type="submit" class="btn">Simpan</button>
    </form>
</div>