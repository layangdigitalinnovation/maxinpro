<?php $__env->startSection('title', ($listing->exists ? 'Edit' : 'Tambah') . ' Listing — MaxinPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex justify-between items-center mb-6">
    <h1 class="text-brand-navy text-[22px] font-black"><?php echo e($listing->exists ? 'Edit Listing' : 'Tambah Listing Baru'); ?></h1>
    <a href="<?php echo e(route('admin.listings.index')); ?>" class="h-11 px-6 inline-flex items-center rounded-lg bg-gray-200 text-brand-navy text-[13px] font-extrabold hover:bg-gray-300">
        Kembali
    </a>
</div>

<?php if($errors->any()): ?>
    <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6 text-sm font-bold">
        Terdapat beberapa kesalahan:
        <ul class="list-disc pl-5 mt-2 font-normal">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?php echo e($listing->exists ? route('admin.listings.update', $listing) : route('admin.listings.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
    <?php echo csrf_field(); ?>
    <?php if($listing->exists): ?>
        <?php echo method_field('PUT'); ?>
    <?php endif; ?>

    <div class="bg-white border border-brand-line rounded-2xl p-6 grid grid-cols-2 gap-6">
        <h2 class="col-span-2 text-brand-navy font-black text-[18px]">Informasi Umum</h2>

        <div class="col-span-2">
            <label class="block text-sm font-bold text-brand-navy mb-2">Judul Listing</label>
            <input type="text" name="title" value="<?php echo e(old('title', $listing->title)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Tipe Properti</label>
            <select name="property_type_id" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
                <option value="">-- Pilih Tipe --</option>
                <?php $__currentLoopData = $propertyTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($pt->id); ?>" <?php echo e(old('property_type_id', $listing->property_type_id) == $pt->id ? 'selected' : ''); ?>><?php echo e($pt->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Area</label>
            <select name="area_id" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
                <option value="">-- Pilih Area --</option>
                <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($area->id); ?>" <?php echo e(old('area_id', $listing->area_id) == $area->id ? 'selected' : ''); ?>><?php echo e($area->name); ?> (<?php echo e($area->city); ?>)</option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Agen (Opsional)</label>
            <select name="agent_id" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">
                <option value="">-- Dikelola Admin --</option>
                <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($ag->id); ?>" <?php echo e(old('agent_id', $listing->agent_id) == $ag->id ? 'selected' : ''); ?>><?php echo e($ag->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Status Penjualan</label>
            <select name="status" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required>
                <?php $__currentLoopData = ['active' => 'Aktif (Ditampilkan)', 'sold' => 'Terjual', 'hidden' => 'Sembunyikan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($val); ?>" <?php echo e(old('status', $listing->status ?? 'active') == $val ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Harga (Rp)</label>
            <input type="number" name="price" value="<?php echo e(old('price', $listing->price)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required min="0">
        </div>
        
        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Badge Khusus (Opsional)</label>
            <select name="badge" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">
                <option value="">-- Tanpa Badge --</option>
                <?php $__currentLoopData = ['Terpopuler', 'Baru', 'Premium']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $badge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($badge); ?>" <?php echo e(old('badge', $listing->badge) == $badge ? 'selected' : ''); ?>><?php echo e($badge); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-bold text-brand-navy mb-2">Alamat Lengkap</label>
            <input type="text" name="address" value="<?php echo e(old('address', $listing->address)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-bold text-brand-navy mb-2">Deskripsi Lengkap</label>
            <textarea name="description" rows="5" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue"><?php echo e(old('description', $listing->description)); ?></textarea>
        </div>
    </div>

    <div class="bg-white border border-brand-line rounded-2xl p-6 grid grid-cols-5 gap-6">
        <h2 class="col-span-5 text-brand-navy font-black text-[18px]">Spesifikasi</h2>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">L. Tanah (m²)</label>
            <input type="number" name="land_area" value="<?php echo e(old('land_area', $listing->land_area)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" min="0">
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">L. Bangunan (m²)</label>
            <input type="number" name="building_area" value="<?php echo e(old('building_area', $listing->building_area)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" min="0">
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">K. Tidur</label>
            <input type="number" name="bedrooms" value="<?php echo e(old('bedrooms', $listing->bedrooms ?? 0)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required min="0">
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">K. Mandi</label>
            <input type="number" name="bathrooms" value="<?php echo e(old('bathrooms', $listing->bathrooms ?? 0)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required min="0">
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Carport/Garasi</label>
            <input type="number" name="car_ports" value="<?php echo e(old('car_ports', $listing->car_ports ?? 0)); ?>" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue" required min="0">
        </div>
    </div>

    <div class="bg-white border border-brand-line rounded-2xl p-6 grid grid-cols-1 gap-6">
        <h2 class="text-brand-navy font-black text-[18px]">Media & Gambar</h2>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Cover Image (Gambar Utama)</label>
            <input type="file" name="cover_image" accept="image/*" class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">
            <div class="text-xs text-gray-500 mt-1">Maksimal 2MB. Kosongkan jika tidak ingin mengubah (saat edit).</div>
        </div>

        <div>
            <label class="block text-sm font-bold text-brand-navy mb-2">Gallery Images (Bisa pilih lebih dari satu)</label>
            <input type="file" name="images[]" accept="image/*" multiple class="w-full border border-brand-line rounded-lg px-4 py-2 focus:ring-brand-blue">
            <div class="text-xs text-gray-500 mt-1">Maksimal 2MB per gambar.</div>
        </div>

        <?php if($listing->exists && $listing->images->count()): ?>
            <div class="mt-4">
                <p class="text-sm font-bold text-brand-navy mb-2">Hapus Gambar Gallery (Centang untuk menghapus)</p>
                <div class="grid grid-cols-4 gap-4">
                    <?php $__currentLoopData = $listing->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="border rounded p-2 flex flex-col items-center cursor-pointer">
                            <img src="<?php echo e(Storage::url($img->path)); ?>" alt="gallery" class="h-20 object-cover mb-2 rounded">
                            <input type="checkbox" name="delete_images[]" value="<?php echo e($img->id); ?>" class="rounded border-red-300 text-red-600 focus:ring-red-500">
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-span-2">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_featured" value="1" <?php echo e(old('is_featured', $listing->is_featured) ? 'checked' : ''); ?> class="rounded border-gray-300 text-brand-blue focus:ring-brand-blue">
            <span class="text-sm font-bold text-brand-navy">Tampilkan sebagai Listing Unggulan (Featured)</span>
        </label>
    </div>

    <div class="flex justify-end pt-4 border-t border-brand-line">
        <button type="submit" class="h-11 px-6 rounded-lg bg-brand-blue text-white text-[13px] font-extrabold hover:bg-blue-700">
            Simpan Data Listing
        </button>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Layang\maxinpro.com\resources\views/admin/listings/form.blade.php ENDPATH**/ ?>