<div>
    @if ($step == 1)
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">
                <i class="fas fa-user"></i> Name
            </label>
            <input type="text" name="name" wire:model="name" class="mt-1 block w-full border p-2 rounded" value="{{ old('name') }}">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">
                <i class="fas fa-envelope"></i> Email
            </label>
            <input type="email" name="email" wire:model="email" class="mt-1 block w-full border p-2 rounded" value="{{ old('email') }}">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
            <input type="text" name="gender" wire:model="gender" class="mt-1 block w-full border p-2 rounded">
            @error('gender') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="batch_year" class="block text-sm font-medium text-gray-700">Batch Year</label>
            <input type="number" name="batch_year" wire:model="batch_year" class="mt-1 block w-full border p-2 rounded">
            @error('batch_year') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="class" class="block text-sm font-medium text-gray-700">Class</label>
            <input type="text" name="class" wire:model="class" class="mt-1 block w-full border p-2 rounded">
            @error('class') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="place_of_birth" class="block text-sm font-medium text-gray-700">Place of Birth</label>
            <input type="text" name="place_of_birth" wire:model="place_of_birth" class="mt-1 block w-full border p-2 rounded">
            @error('place_of_birth') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
            <input type="date" name="date_of_birth" wire:model="date_of_birth" class="mt-1 block w-full border p-2 rounded">
            @error('date_of_birth') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="nisn" class="block text-sm font-medium text-gray-700">NISN</label>
            <input type="text" name="nisn" wire:model="nisn" class="mt-1 block w-full border p-2 rounded">
            @error('nisn') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input type="text" name="phone_number" wire:model="phone_number" class="mt-1 block w-full border p-2 rounded">
            @error('phone_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" wire:model="status" class="mt-1 block w-full border p-2 rounded">
                <option value="">Select Status</option>
                <option value="active">Active</option>
                <option value="graduated">Graduated</option>
            </select>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="button" wire:click="submit" class="bg-blue-500 text-white p-2 rounded">
                <i class="fas fa-arrow-right"></i> Next
            </button>
        </div>
    @elseif ($step == 2)
        <div class="mb-4">
            <label for="address.street" class="block text-sm font-medium text-gray-700">Street</label>
            <input type="text" name="address.street" wire:model="address.street" class="mt-1 block w-full border p-2 rounded">
            @error('address.street') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="address.subdistrict" class="block text-sm font-medium text-gray-700">Subdistrict</label>
            <input type="text" name="address.subdistrict" wire:model="address.subdistrict" class="mt-1 block w-full border p-2 rounded">
            @error('address.subdistrict') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="address.district" class="block text-sm font-medium text-gray-700">District</label>
            <input type="text" name="address.district" wire:model="address.district" class="mt-1 block w-full border p-2 rounded">
            @error('address.district') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="address.city" class="block text-sm font-medium text-gray-700">City</label>
            <input type="text" name="address.city" wire:model="address.city" class="mt-1 block w-full border p-2 rounded">
            @error('address.city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="address.province" class="block text-sm font-medium text-gray-700">Province</label>
            <input type="text" name="address.province" wire:model="address.province" class="mt-1 block w-full border p-2 rounded">
            @error('address.province') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="address.postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
            <input type="text" name="address.postal_code" wire:model="address.postal_code" class="mt-1 block w-full border p-2 rounded">
            @error('address.postal_code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        @if ($status == 'active')
            <div class="mb-4">
                <label for="school_choice.first_choice" class="block text-sm font-medium text-gray-700">First Choice</label>
                <input type="text" name="school_choice.first_choice" wire:model="school_choice.first_choice" class="mt-1 block w-full border p-2 rounded">
                @error('school_choice.first_choice') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="school_choice.second_choice" class="block text-sm font-medium text-gray-700">Second Choice</label>
                <input type="text" name="school_choice.second_choice" wire:model="school_choice.second_choice" class="mt-1 block w-full border p-2 rounded">
                @error('school_choice.second_choice') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="school_choice.third_choice" class="block text-sm font-medium text-gray-700">Third Choice</label>
                <input type="text" name="school_choice.third_choice" wire:model="school_choice.third_choice" class="mt-1 block w-full border p-2 rounded">
                @error('school_choice.third_choice') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        @elseif ($status == 'graduated')
            <div class="mb-4">
                <label for="graduated_school.selected_school" class="block text-sm font-medium text-gray-700">Selected School</label>
                <input type="text" name="graduated_school.selected_school" wire:model="graduated_school.selected_school" class="mt-1 block w-full border p-2 rounded">
                @error('graduated_school.selected_school') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="graduated_school.accepted_school" class="block text-sm font-medium text-gray-700">Accepted School</label>
                <input type="text" name="graduated_school.accepted_school" wire:model="graduated_school.accepted_school" class="mt-1 block w-full border p-2 rounded">
                @error('graduated_school.accepted_school') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        @endif

        <div class="flex items-center justify-end mt-4">
            <button type="button" wire:click="back" class="bg-gray-500 text-white p-2 rounded mr-2">
                <i class="fas fa-arrow-left"></i> Back
            </button>
            <button type="button" wire:click="submit" class="bg-blue-500 text-white p-2 rounded">
                <i class="fas fa-save"></i> Submit
            </button>
        </div>
    @endif
</div>
