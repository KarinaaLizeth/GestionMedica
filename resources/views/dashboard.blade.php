<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (Auth::check())
                        @php
                            $user = Auth::user();
                            $roleName = strtolower($user->role->nombre ?? '');
                            $welcomeMessage = '';

                            if ($roleName === 'doctor') {
                                $welcomeMessage = "Bienvenido Doctor {$user->name}";
                            } elseif ($roleName === 'Secretaria') {
                                $welcomeMessage = "Bienvenida Secretaria {$user->name}";
                            } elseif ($roleName === 'admin') {
                                $welcomeMessage = "Bienvenido Administrador {$user->name}";
                            }
                        @endphp
                        <p class="text-green-600 font-bold">{{ $welcomeMessage }}</p>
                        <p class="text-red-600">Debug Info: {{ $roleName }}</p> <!-- Línea de depuración -->
                    @else
                        <p class="text-green-600 font-bold">{{ __("You're logged in!") }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



    <!-- component -->
<!-- This is an example component -->
<div>
    <div class="bg-indigo-900 px-4 py-4">
      <div
        class="md:max-w-6xl md:mx-auto md:flex md:items-center md:justify-between"
      >
        <div class="flex justify-between items-center">
          <a href="#" class="inline-block py-2 text-white text-xl font-bold"
            >Demopay</a
          >
          <div
            class="inline-block cursor-pointer md:hidden">
            <div class="bg-gray-400 w-8 mb-2" style="height: 2px;"></div>
            <div class="bg-gray-400 w-8 mb-2" style="height: 2px;"></div>
            <div class="bg-gray-400 w-8" style="height: 2px;"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="bg-indigo-900 md:overflow-hidden">
      <div class="px-4 py-20 md:py-4">
        <div class="md:max-w-6xl md:mx-auto">
          <div class="md:flex md:flex-wrap">
            <div class="md:w-1/2 text-center md:text-left md:pt-16">
              <h1
                class="font-bold text-white text-2xl md:text-5xl leading-tight mb-4"
              >
                Simple payment platform for any service
              </h1>

              <p class="text-indigo-200 md:text-xl md:pr-48">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Id
                vitae corrupti asperiores veritatis dolorum, commodi aperiam
                enim.
              </p>

              <a
                href="#"
                class="mt-6 mb-12 md:mb-0 md:mt-10 inline-block py-3 px-8 text-white bg-red-500 hover:bg-red-600 rounded-lg shadow"
                >Get Started</a
              >
            </div>
            <div class="md:w-1/2 relative">
              <div class="hidden md:block">
                <div
                  class="-ml-24 -mb-40 absolute left-0 bottom-0 w-40 bg-white rounded-lg shadow-lg px-6 py-8"
                  style="transform: rotate(-8deg);"
                >
                  <div
                    class="bg-indigo-800 mx-auto rounded-lg px-2 pb-2 relative mb-8"
                  >
                    <div class="mb-1">
                      <span
                        class="w-1 h-1 bg-indigo-100 rounded-full inline-block"
                        style="margin-right: 1px;"
                      ></span
                      ><span
                        class="w-1 h-1 bg-indigo-100 rounded-full inline-block"
                        style="margin-right: 1px;"
                      ></span
                      ><span
                        class="w-1 h-1 bg-indigo-100 rounded-full inline-block"
                      ></span>
                    </div>
                    <div class="h-1 w-12 bg-indigo-100 rounded mb-1"></div>
                    <div class="h-1 w-10 bg-indigo-100 rounded mb-2"></div>

                    <div class="flex">
                      <div class="w-6 h-3 rounded bg-indigo-100 mr-1"></div>
                      <div class="w-6 h-3 rounded bg-indigo-100"></div>
                    </div>

                    <div
                      class="-mr-2 -mb-4 absolute bottom-0 right-0 h-16 w-10 rounded-lg bg-green-700 border-2 border-white"
                    ></div>
                    <div
                      class="w-2 h-2 rounded-full bg-green-800 mx-auto absolute bottom-0 right-0 mr-2 -mb-2 z-10 border-2 border-white"
                    ></div>
                  </div>

                  <div class="text-gray-800 text-center">
                    Online <br />Services
                  </div>
                </div>

                <div
                  class="ml-24 mb-16 absolute left-0 bottom-0 w-40 bg-white rounded-lg shadow-lg px-6 py-8"
                  style="transform: rotate(-8deg); z-index: 2;"
                >
                  <div
                    class="bg-indigo-800 mx-auto rounded-lg relative mb-8 py-2 w-20 border-2 border-white"
                  >
                    <div
                      class="h-8 bg-green-700 w-8 rounded absolute left-0 top-0 -mt-3 ml-4"
                      style="transform: rotate(-45deg); z-index: -1;"
                    ></div>
                    <div
                      class="h-8 bg-green-800 w-8 rounded absolute left-0 top-0 -mt-3 ml-8"
                      style="transform: rotate(-12deg); z-index: -2;"
                    ></div>

                    <div
                      class="flex items-center justify-center h-6 bg-indigo-800 w-6 rounded-l-lg ml-auto border-4 border-white -mr-1"
                    >
                      <div
                        class="h-2 w-2 rounded-full bg-indigo-800 border-2 border-white"
                      ></div>
                    </div>

                    <div
                      class="w-8 h-8 bg-green-700 border-4 border-white rounded-full -ml-3 -mb-5"
                    ></div>
                  </div>

                  <div class="text-gray-800 text-center">
                    Banking Services
                  </div>
                </div>

                <div
                  class="ml-32 absolute left-0 bottom-0 w-48 bg-white rounded-lg shadow-lg px-10 py-8"
                  style="transform: rotate(-8deg); z-index: 2; margin-bottom: -220px;"
                >
                  <div
                    class="bg-indigo-800 mx-auto rounded-lg pt-4 mb-16 relative"
                  >
                    <div class="h-4 bg-white"></div>

                    <div class="text-right my-2 pb-1">
                      <div
                        class="inline-flex w-3 h-3 rounded-full bg-white -mr-2"
                      ></div>
                      <div
                        class="inline-flex w-3 h-3 rounded-full bg-indigo-800 border-2 border-white mr-2"
                      ></div>
                    </div>

                    <div
                      class="-ml-4 -mb-6 absolute left-0 bottom-0 w-16 bg-green-700 mx-auto rounded-lg pb-2 pt-3"
                    >
                      <div class="h-2 bg-white mb-2"></div>
                      <div class="h-2 bg-white w-6 ml-auto rounded mr-2"></div>
                    </div>
                  </div>

                  <div class="text-gray-800 text-center">
                    Payment for <br />Internet
                  </div>
                </div>

                <div
                  class="mt-10 w-full absolute right-0 top-0 flex rounded-lg bg-white overflow-hidden shadow-lg"
                  style="transform: rotate(-8deg); margin-right: -250px; z-index: 1;"
                >
                  <div class="w-32 bg-gray-200" style="height: 560px;"></div>
                  <div class="flex-1 p-6">
                    <h2 class="text-lg text-gray-700 font-bold mb-3">
                      Popular Payments
                    </h2>
                    <div class="flex mb-5">
                      <div class="w-16 rounded-full bg-gray-100 py-2 px-4 mr-2">
                        <div class="p-1 rounded-full bg-gray-300"></div>
                      </div>
                      <div class="w-16 rounded-full bg-gray-100 py-2 px-4 mr-2">
                        <div class="p-1 rounded-full bg-gray-300"></div>
                      </div>
                      <div class="w-16 rounded-full bg-gray-100 py-2 px-4 mr-2">
                        <div class="p-1 rounded-full bg-gray-300"></div>
                      </div>
                      <div class="w-16 rounded-full bg-gray-100 py-2 px-4">
                        <div class="p-1 rounded-full bg-gray-300"></div>
                      </div>
                    </div>

                    <div class="flex flex-wrap -mx-4 mb-5">
                      <div class="w-1/3 px-4">
                        <div class="h-40 rounded-lg bg-white shadow-lg p-6">
                          <div
                            class="w-16 h-16 rounded-full bg-gray-200 mb-6"
                          ></div>
                          <div
                            class="h-2 w-16 bg-gray-200 mb-2 rounded-full"
                          ></div>
                          <div class="h-2 w-10 bg-gray-200 rounded-full"></div>
                        </div>
                      </div>
                      <div class="w-1/3 px-4">
                        <div class="h-40 rounded-lg bg-white shadow-lg p-6">
                          <div
                            class="w-16 h-16 rounded-full bg-gray-200 mb-6"
                          ></div>
                          <div
                            class="h-2 w-16 bg-gray-200 mb-2 rounded-full"
                          ></div>
                          <div class="h-2 w-10 bg-gray-200 rounded-full"></div>
                        </div>
                      </div>
                      <div class="w-1/3 px-4">
                        <div class="h-40 rounded-lg bg-white shadow-lg p-6">
                          <div
                            class="w-16 h-16 rounded-full bg-gray-200 mb-6"
                          ></div>
                          <div
                            class="h-2 w-16 bg-gray-200 mb-2 rounded-full"
                          ></div>
                          <div class="h-2 w-10 bg-gray-200 rounded-full"></div>
                        </div>
                      </div>
                    </div>

                    <h2 class="text-lg text-gray-700 font-bold mb-3">
                      Popular Payments
                    </h2>

                    <div
                      class="w-full flex flex-wrap justify-between items-center border-b-2 border-gray-100 py-3"
                    >
                      <div class="w-1/3">
                        <div class="flex">
                          <div class="h-8 w-8 rounded bg-gray-200 mr-4"></div>
                          <div>
                            <div
                              class="h-2 w-16 bg-gray-200 mb-1 rounded-full"
                            ></div>
                            <div
                              class="h-2 w-10 bg-gray-100 rounded-full"
                            ></div>
                          </div>
                        </div>
                      </div>
                      <div class="w-1/3">
                        <div
                          class="w-16 rounded-full bg-green-100 py-2 px-4 mx-auto"
                        >
                          <div class="p-1 rounded-full bg-green-200"></div>
                        </div>
                      </div>
                      <div class="w-1/3">
                        <div
                          class="h-2 w-10 bg-gray-100 rounded-full mx-auto"
                        ></div>
                      </div>
                    </div>

                    <div
                      class="flex flex-wrap justify-between items-center border-b-2 border-gray-100 py-3"
                    >
                      <div class="w-1/3">
                        <div class="flex">
                          <div class="h-8 w-8 rounded bg-gray-200 mr-4"></div>
                          <div>
                            <div
                              class="h-2 w-16 bg-gray-200 mb-1 rounded-full"
                            ></div>
                            <div
                              class="h-2 w-10 bg-gray-100 rounded-full"
                            ></div>
                          </div>
                        </div>
                      </div>
                      <div class="w-1/3">
                        <div
                          class="w-16 rounded-full bg-orange-100 py-2 px-4 mx-auto"
                        >
                          <div class="p-1 rounded-full bg-orange-200"></div>
                        </div>
                      </div>
                      <div class="w-1/3">
                        <div
                          class="h-2 w-16 bg-gray-100 rounded-full mx-auto"
                        ></div>
                      </div>
                    </div>

                    <div
                      class="flex flex-wrap justify-between items-center border-b-2 border-gray-100 py-3"
                    >
                      <div class="w-1/3">
                        <div class="flex">
                          <div class="h-8 w-8 rounded bg-gray-200 mr-4"></div>
                          <div>
                            <div
                              class="h-2 w-16 bg-gray-200 mb-1 rounded-full"
                            ></div>
                            <div
                              class="h-2 w-10 bg-gray-100 rounded-full"
                            ></div>
                          </div>
                        </div>
                      </div>
                      <div class="w-1/3">
                        <div
                          class="w-16 rounded-full bg-blue-100 py-2 px-4 mx-auto"
                        >
                          <div class="p-1 rounded-full bg-blue-200"></div>
                        </div>
                      </div>
                      <div class="w-1/3">
                        <div
                          class="h-2 w-8 bg-gray-100 rounded-full mx-auto"
                        ></div>
                      </div>
                    </div>
                  </div>
                </div>

                <div
                  class="w-full absolute left-0 bottom-0 ml-1"
                  style="transform: rotate(-8deg); z-index: 1; margin-bottom: -360px;"
                >
                  <div class="grid--gray h-48 w-48"></div>
                </div>
              </div>

              <div
                class="md:hidden w-full absolute right-0 top-0 flex rounded-lg bg-white overflow-hidden shadow"
              >
                <div
                  class="h-4 bg-gray-200 absolute top-0 left-0 right-0 rounded-t-lg flex items-center"
                >
                  <span
                    class="h-2 w-2 rounded-full bg-red-500 inline-block mr-1 ml-2"
                  ></span>
                  <span
                    class="h-2 w-2 rounded-full bg-orange-400 inline-block mr-1"
                  ></span>
                  <span
                    class="h-2 w-2 rounded-full bg-green-500 inline-block mr-1"
                  ></span>
                </div>
                <div class="w-32 bg-gray-100 px-2 py-8" style="height: 340px;">
                  <div class="h-2 w-16 bg-gray-300 rounded-full mb-4"></div>
                  <div class="flex items-center mb-4">
                    <div
                      class="h-5 w-5 rounded-full bg-gray-300 mr-3 flex-shrink-0"
                    ></div>
                    <div>
                      <div class="h-2 w-10 bg-gray-300 rounded-full"></div>
                    </div>
                  </div>

                  <div class="h-2 w-16 bg-gray-200 rounded-full mb-2"></div>
                  <div class="h-2 w-10 bg-gray-200 rounded-full mb-2"></div>
                  <div class="h-2 w-20 bg-gray-200 rounded-full mb-2"></div>
                  <div class="h-2 w-6 bg-gray-200 rounded-full mb-2"></div>
                  <div class="h-2 w-16 bg-gray-200 rounded-full mb-2"></div>
                  <div class="h-2 w-10 bg-gray-200 rounded-full mb-2"></div>
                  <div class="h-2 w-20 bg-gray-200 rounded-full mb-2"></div>
                  <div class="h-2 w-6 bg-gray-200 rounded-full mb-2"></div>
                </div>
                <div class="flex-1 px-4 py-8">
                  <h2 class="text-xs text-gray-700 font-bold mb-1">
                    Popular Payments
                  </h2>
                  <div class="flex mb-5">
                    <div class="p-2 w-12 rounded-full bg-gray-100 mr-2"></div>
                    <div class="p-2 w-12 rounded-full bg-gray-100 mr-2"></div>
                    <div class="p-2 w-12 rounded-full bg-gray-100 mr-2"></div>
                    <div class="p-2 w-12 rounded-full bg-gray-100 mr-2"></div>
                  </div>

                  <div class="flex flex-wrap -mx-2 mb-5">
                    <div class="w-1/3 px-2">
                      <div class="p-3 rounded-lg bg-white shadow">
                        <div
                          class="w-6 h-6 rounded-full bg-gray-200 mb-2"
                        ></div>
                        <div
                          class="h-2 w-10 bg-gray-200 mb-1 rounded-full"
                        ></div>
                        <div class="h-2 w-6 bg-gray-200 rounded-full"></div>
                      </div>
                    </div>
                    <div class="w-1/3 px-2">
                      <div class="p-3 rounded-lg bg-white shadow">
                        <div
                          class="w-6 h-6 rounded-full bg-gray-200 mb-2"
                        ></div>
                        <div
                          class="h-2 w-10 bg-gray-200 mb-1 rounded-full"
                        ></div>
                        <div class="h-2 w-6 bg-gray-200 rounded-full"></div>
                      </div>
                    </div>
                    <div class="w-1/3 px-2">
                      <div class="p-3 rounded-lg bg-white shadow">
                        <div
                          class="w-6 h-6 rounded-full bg-gray-200 mb-2"
                        ></div>
                        <div
                          class="h-2 w-10 bg-gray-200 mb-1 rounded-full"
                        ></div>
                        <div class="h-2 w-6 bg-gray-200 rounded-full"></div>
                      </div>
                    </div>
                  </div>

                  <h2 class="text-xs text-gray-700 font-bold mb-1">
                    Popular Payments
                  </h2>

                  <div
                    class="w-full flex flex-wrap justify-between items-center border-b-2 border-gray-100 py-3"
                  >
                    <div class="w-1/3">
                      <div class="flex">
                        <div
                          class="h-5 w-5 rounded-full bg-gray-200 mr-3 flex-shrink-0"
                        ></div>
                        <div>
                          <div
                            class="h-2 w-16 bg-gray-200 mb-1 rounded-full"
                          ></div>
                          <div class="h-2 w-10 bg-gray-100 rounded-full"></div>
                        </div>
                      </div>
                    </div>
                    <div class="w-1/3">
                      <div
                        class="w-16 rounded-full bg-green-100 py-2 px-4 mx-auto"
                      >
                        <div class="p-1 rounded-full bg-green-200"></div>
                      </div>
                    </div>
                    <div class="w-1/3">
                      <div
                        class="h-2 w-10 bg-gray-100 rounded-full mx-auto"
                      ></div>
                    </div>
                  </div>

                  <div class="flex flex-wrap justify-between items-center py-3">
                    <div class="w-1/3">
                      <div class="flex">
                        <div
                          class="h-5 w-5 rounded-full bg-gray-200 mr-3 flex-shrink-0"
                        ></div>
                        <div>
                          <div
                            class="h-2 w-16 bg-gray-200 mb-1 rounded-full"
                          ></div>
                          <div class="h-2 w-10 bg-gray-100 rounded-full"></div>
                        </div>
                      </div>
                    </div>
                    <div class="w-1/3">
                      <div
                        class="w-16 rounded-full bg-orange-100 py-2 px-4 mx-auto"
                      >
                        <div class="p-1 rounded-full bg-orange-200"></div>
                      </div>
                    </div>
                    <div class="w-1/3">
                      <div
                        class="h-2 w-16 bg-gray-100 rounded-full mx-auto"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>

              <div
                class="mr-3 md:hidden absolute right-0 bottom-0 w-40 bg-white rounded-lg shadow-lg px-10 py-6"
                style="z-index: 2; margin-bottom: -380px;"
              >
                <div
                  class="bg-indigo-800 mx-auto rounded-lg w-20 pt-3 mb-12 relative"
                >
                  <div class="h-3 bg-white"></div>

                  <div class="text-right my-2">
                    <div
                      class="inline-flex w-3 h-3 rounded-full bg-white -mr-2"
                    ></div>
                    <div
                      class="inline-flex w-3 h-3 rounded-full bg-indigo-800 border-2 border-white mr-2"
                    ></div>
                  </div>

                  <div
                    class="-ml-4 -mb-6 absolute left-0 bottom-0 w-16 bg-green-700 mx-auto rounded-lg pb-2 pt-3"
                  >
                    <div class="h-2 bg-white mb-2"></div>
                    <div class="h-2 bg-white w-6 ml-auto rounded mr-2"></div>
                  </div>
                </div>

                <div class="text-gray-800 text-center text-sm">
                  Payment for <br />Internet
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <svg
        class="fill-current text-white hidden md:block"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 1440 320"
      >
        <path fill-opacity="1" d="M0,224L1440,32L1440,320L0,320Z"></path>
      </svg>
    </div>
</div>
<!-- component -->
<div class="p-24 flex flex-wrap items-center justify-center">
    
    <div class="flex-shrink-0 m-6 relative overflow-hidden bg-orange-500 rounded-lg max-w-xs shadow-lg">
      <svg class="absolute bottom-0 left-0 mb-8" viewBox="0 0 375 283" fill="none" style="transform: scale(1.5); opacity: 0.1;">
        <rect x="159.52" y="175" width="152" height="152" rx="8" transform="rotate(-45 159.52 175)" fill="white"/>
        <rect y="107.48" width="152" height="152" rx="8" transform="rotate(-45 0 107.48)" fill="white"/>
      </svg>
      <div class="relative pt-10 px-10 flex items-center justify-center">
        <div class="block absolute w-48 h-48 bottom-0 left-0 -mb-24 ml-3" style="background: radial-gradient(black, transparent 60%); transform: rotate3d(0, 0, 1, 20deg) scale3d(1, 0.6, 1); opacity: 0.2;"></div>
        <img class="relative w-40" src="https://user-images.githubusercontent.com/2805249/64069899-8bdaa180-cc97-11e9-9b19-1a9e1a254c18.png" alt="">
      </div>
      <div class="relative text-white px-6 pb-6 mt-6">
        <span class="block opacity-75 -mb-1">Indoor</span>
        <div class="flex justify-between">
          <span class="block font-semibold text-xl">Peace Lily</span>
          <span class="block bg-white rounded-full text-orange-500 text-xs font-bold px-3 py-2 leading-none flex items-center">$36.00</span>
        </div>
      </div>
    </div>
    <div class="flex-shrink-0 m-6 relative overflow-hidden bg-teal-500 rounded-lg max-w-xs shadow-lg">
      <svg class="absolute bottom-0 left-0 mb-8" viewBox="0 0 375 283" fill="none" style="transform: scale(1.5); opacity: 0.1;">
        <rect x="159.52" y="175" width="152" height="152" rx="8" transform="rotate(-45 159.52 175)" fill="white"/>
        <rect y="107.48" width="152" height="152" rx="8" transform="rotate(-45 0 107.48)" fill="white"/>
      </svg>
      <div class="relative pt-10 px-10 flex items-center justify-center">
        <div class="block absolute w-48 h-48 bottom-0 left-0 -mb-24 ml-3" style="background: radial-gradient(black, transparent 60%); transform: rotate3d(0, 0, 1, 20deg) scale3d(1, 0.6, 1); opacity: 0.2;"></div>
        <img class="relative w-40" src="https://user-images.githubusercontent.com/2805249/64069998-305de300-cc9a-11e9-8ae7-5a0fe00299f2.png" alt="">
      </div>
      <div class="relative text-white px-6 pb-6 mt-6">
        <span class="block opacity-75 -mb-1">Outdoor</span>
        <div class="flex justify-between">
          <span class="block font-semibold text-xl">Monstera</span>
          <span class="block bg-white rounded-full text-teal-500 text-xs font-bold px-3 py-2 leading-none flex items-center">$45.00</span>
        </div>
      </div>
    </div>
    <div class="flex-shrink-0 m-6 relative overflow-hidden bg-purple-500 rounded-lg max-w-xs shadow-lg">
      <svg class="absolute bottom-0 left-0 mb-8" viewBox="0 0 375 283" fill="none" style="transform: scale(1.5); opacity: 0.1;">
        <rect x="159.52" y="175" width="152" height="152" rx="8" transform="rotate(-45 159.52 175)" fill="white"/>
        <rect y="107.48" width="152" height="152" rx="8" transform="rotate(-45 0 107.48)" fill="white"/>
      </svg>
      <div class="relative pt-10 px-10 flex items-center justify-center">
        <div class="block absolute w-48 h-48 bottom-0 left-0 -mb-24 ml-3" style="background: radial-gradient(black, transparent 60%); transform: rotate3d(0, 0, 1, 20deg) scale3d(1, 0.6, 1); opacity: 0.2;"></div>
        <img class="relative w-40" src="https://user-images.githubusercontent.com/2805249/64069899-8bdaa180-cc97-11e9-9b19-1a9e1a254c18.png" alt="">
      </div>
      <div class="relative text-white px-6 pb-6 mt-6">
        <span class="block opacity-75 -mb-1">Outdoor</span>
        <div class="flex justify-between">
          <span class="block font-semibold text-xl">Oak Tree</span>
          <span class="block bg-white rounded-full text-purple-500 text-xs font-bold px-3 py-2 leading-none flex items-center">$68.50</span>
        </div>
      </div>
    </div>
    
  </div>
<!-- component -->
<header>

  <!-- Section Hero -->
  <div class="bg-green-100 py-14">
    <h3 class="text-2xl tracking-widest text-green-600 text-center">FEATURES</h3>
    <h1 class="mt-8 text-center text-5xl text-green-600 font-bold">Our Features & Services.</h1>

    <!-- Box -->
    <div class="md:flex md:justify-center md:space-x-8 md:px-14">
      <!-- box-1 -->
      <div class="mt-16 py-4 px-4 bg-whit w-72 bg-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-110 transition duration-500 mx-auto md:mx-0">
        <div class="w-sm">
          <img class="w-64" src="https://images01.nicepage.com/c461c07a441a5d220e8feb1a/a17abde8d83650a582a28432/users-with-speech-bubbles-vector_53876-82250.jpg" alt="" />
          <div class="mt-4 text-green-600 text-center">
            <h1 class="text-xl font-bold">Communications</h1>
            <p class="mt-4 text-gray-600">Pretium lectus quam id leo in vitae turpis. Mattis pellentesque id nibh tortor id.</p>
            <button class="mt-8 mb-4 py-2 px-14 rounded-full bg-green-600 text-white tracking-widest hover:bg-green-500 transition duration-200">MORE</button>
          </div>
        </div>
      </div>

      <!-- box-2 -->
      <div class="mt-16 py-4 px-4 bg-whit w-72 bg-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-110 transition duration-500 mx-auto md:mx-0">
        <div class="w-sm">
          <img class="w-64" src="https://images01.nicepage.com/c461c07a441a5d220e8feb1a/3b242447f922540fbe750cab/fdf.jpg" alt="" />
          <div class="mt-4 text-green-600 text-center">
            <h1 class="text-xl font-bold">Inspired Design</h1>
            <p class="mt-4 text-gray-600">Nunc consequat interdum varius sit amet mattis vulputate enim nulla. Risus feugiat.</p>
            <button class="mt-8 mb-4 py-2 px-14 rounded-full bg-green-600 text-white tracking-widest hover:bg-green-500 transition duration-200">MORE</button>
          </div>
        </div>
      </div>

      <!-- box-3 -->
      <div class="mt-16 py-4 px-4 bg-whit w-72 bg-white rounded-xl shadow-lg hover:shadow-xl transform hover:scale-110 transition duration-500 mx-auto md:mx-0">
        <div class="w-sm">
          <img class="w-64" src="https://images01.nicepage.com/c461c07a441a5d220e8feb1a/8cc47b39e719570b996d9879/dsds.jpg" alt="" />
          <div class="mt-4 text-green-600 text-center">
            <h1 class="text-xl font-bold">Happy Customers</h1>
            <p class="mt-4 text-gray-600">Nisl purus in mollis nunc sed id semper. Rhoncus aenean vel elit scelerisque mauris.</p>
            <button class="mt-8 mb-4 py-2 px-14 rounded-full bg-green-600 text-white tracking-widest hover:bg-green-500 transition duration-200">MORE</button>
          </div>
        </div>
      </div>
    </div>
    <h4 class="text-center font-thin text-xl mt-14">Image from <span class="underline text-gray-600 cursor-pointer">Freepik</span></h4>
  </div>
</header>

<!-- Footer -->
<footer class="text-center py-16 bg-gray-700 text-sm">
  <p class="text-white">
    Sample text. Click to select the text box. Click again or double <br />
    click to start editing the text.
  </p>
  <p class="mt-20 text-white"><span class="underline text-green-200 cursor-pointer">Website Templates </span>created with <span class="underline text-green-200 cursor-pointer">Website Builder Software.</span></p>
</footer>
