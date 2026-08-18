<x-app-layout>
 <x-slot name="header"><h2 class="font-semibold text-xl">Platform Administration</h2></x-slot>
 <div class="py-8 max-w-7xl mx-auto px-4">
  @if(session('message'))<div class="mb-4 p-3 bg-green-100">{{ session('message') }}</div>@endif
  <div class="bg-white p-6 shadow sm:rounded-lg mb-6">
   <h3 class="font-bold mb-3">Create household</h3>
   <form method="POST" action="{{ route('platform.households.store') }}" class="grid gap-3 md:grid-cols-4">@csrf
    <input name="name" placeholder="Household name" required><input name="owner_name" placeholder="Owner name" required><input name="owner_email" type="email" placeholder="Owner email" required>
    <select name="plan_id" required>@foreach($plans as $plan)<option value="{{ $plan->id }}">{{ $plan->name }} - {{ $plan->price }}</option>@endforeach</select><button class="bg-blue-600 text-white p-2">Create</button>
   </form>
  </div>
  <div class="bg-white p-6 shadow sm:rounded-lg"><h3 class="font-bold mb-3">Households</h3><table class="w-full"><tr><th>Name</th><th>Owner</th><th>Plan</th><th>Status</th><th></th></tr>@foreach($households as $household)<tr><td>{{ $household->name }}</td><td>{{ $household->owner?->email }}</td><td>{{ $household->subscription?->plan?->name }}</td><td>{{ $household->status }}</td><td><form method="POST" action="{{ route('platform.households.status', $household) }}">@csrf @method('PATCH')<input type="hidden" name="status" value="{{ $household->status === 'active' ? 'suspended' : 'active' }}"><button>{{ $household->status === 'active' ? 'Suspend' : 'Activate' }}</button></form></td></tr>@endforeach</table>{{ $households->links() }}</div>
 </div>
</x-app-layout>
