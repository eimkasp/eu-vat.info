  <div>
      <h3 class="text-base font-semibold leading-6 text-gray-900">Available VAT rates in {{ $country->name }}</h3>
      <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">
          <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
              <dt class="truncate text-sm font-medium text-gray-500">Standard rate</dt>
              <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                  {{ $country->standard_rate }}%
              </dd>
          </div>
          <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
              <dt class="truncate text-sm font-medium text-gray-500">Reduced rate</dt>
              <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                  {{ $country->reduced_rate }}%
              </dd>
          </div>
          @if ($country->parking_rate)
              <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                  <dt class="truncate text-sm font-medium text-gray-500">Parking rate</dt>
                  <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                      {{ $country->parking_rate }}%
                  </dd>
              </div>
          @endif

          @if ($country->super_reduced_rate)
              <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                  <dt class="truncate text-sm font-medium text-gray-500">Super Reduced rate</dt>
                  <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                      {{ $country->super_reduced_rate }}%
                  </dd>
              </div>
          @endif
      </dl>
  </div>
