<div class="mb-6">
  @if (!$berhasilDaftar)
  <h1 class="text-3xl pb-8">Form Pendaftaran Santri Baru IDN Boarding School</h1>
    <form wire:submit="store">
        @csrf
        <div class="form-row">
          <div class="form-group col-md-6">
            <label>Username</label>
            <input wire:model="email" type="email" class="form-control" id="inputEmail" placeholder="username@gmail.com">
            @error('email')
                <p class="text-sm text-danger">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group col-md-6">
            <label>Password</label>
            <input wire:model="password" type="password" class="form-control" id="inputPassword" placeholder="password">
            @error('password')
                <p class="text-sm text-danger">{{ $message }}</p>
            @enderror
          </div>
        </div>
        <div class="form-group">
            <label>Nama Santri</label>
            <input wire:model="namaSantri" type="text" class="form-control" id="inputNamaSantri" placeholder="nama santri">
            @error('namaSantri')
                <p class="text-sm text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <div>    
                <label>Jenis Kelamin</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input wire:model="jenisKelamin" value="laki-laki" type="radio" id="customRadioInline1" name="customRadioInline" class="custom-control-input">
                <label class="custom-control-label" for="customRadioInline1">Laki-Laki</label>
              </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input wire:model="jenisKelamin" value="perempuan" type="radio" id="customRadioInline2" name="customRadioInline" class="custom-control-input">
                <label class="custom-control-label" for="customRadioInline2">Perempuan</label>
            </div>
            @error('jenisKelamin')
                <p class="text-sm text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="inputState">Cabang IDN</label>
            <select wire:model.live="cabangIdn" id="inputState" class="form-control">
              <option selected>pilih cabang</option>
              @forelse ($cabangIdns as $cabang)
                <option value="{{ $cabang->id }}">{{ $cabang->nama_cabang }}</option>
              @empty
                <option selected>tidak ada cabang</option>
              @endforelse
            </select>
            @error('cabangIdn')
                <p class="text-sm text-danger">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group col-md-4">
            <label for="inputState">Program IDN</label>
            @if (isset($programIdns))
            <select wire:model.live="programIdn" id="inputState" class="form-control">
                @if ($optionProgram)
                  <option selected>pilih program</option>
                @endif
                @forelse ($programIdns as $program)
                  <option value="{{ $program->id }}">{{ $program->name }}</option>
                @empty
                  <option>tidak ada program</option>
                @endforelse
              </select>
              @error('programIdn')
                <p class="text-sm text-danger">{{ $message }}</p>
            @enderror
            @endif
          </div>
        </div>
        <div>
          <label>Bukti Transfer</label>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
            </div>
            <div class="custom-file">
              <input wire:model="image" type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
              <label class="custom-file-label" for="inputGroupFile01">{{ $image ? $image->getClientOriginalName() : 'Choose file' }}</label>
            </div>
          </div>
        @error('image')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
        
        @if ($image)
        <div class="pb-10">
          <img src="{{ $image->temporaryUrl() }}" alt="gambar" height="200">
        </div>
        @endif
      
        <button 
        @if ($kuotaFull)
            disabled
        @endif type="submit" class="btn btn-primary bg-primary">Daftar</button>
    </form>
  @else
    <div x-data="{login: false}" class="text-center">
      <div>Silahkan <button @click="login=true" class="btn btn-primary">Login</button></div>
      <div x-show="login">
        @include('auth.login')
      </div>
    </div>
  @endif
</div>

@push('scripts')
  <script>
    document.addEventListener('livewire:initialized', () => {
       @this.on('kuotaFull', (event) => {
          if(event) {
            Swal.fire({
              text: `Kuota untuk ${event[0][1]} di ${event[0][2]} sudah penuh, silahkan pilih program yang lain`,
              target: '#custom-target',
              customClass: {
                container: 'position-absolute'
              },
              toast: true,
              position: 'top-middle'
            })
          }
       });
    });

    document.addEventListener('livewire:initialized', () => {
       @this.on('daftarBerhasil', (event) => {
          if(event) {
            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
              }
            })

            Toast.fire({
              icon: 'success',
              title: 'Selamat! Pendaftaran Berhasil'
            })
          }
       });
    });
  </script>
@endpush
