@extends('layouts.app')

@section('title', 'Cell-a Juvenescence Indonesia')

@section('content')

    <section class="conn-section py-8 flex gap-16 px-4" x-data="{
        categories: @js($categories),
        isOpenAll: true,
        openAll: 'All Topics',
        topics: @js($topics),
        init() {
            this.topics = this.topics?.map(faq => ({ ...faq, isSelected: false }))

            console.log(this.topics[0].qna[0])
        },
        selectFilter(topicName) {
            if (!topicName) return;

            if (topicName == this.openAll) {
                this.isOpenAll = true

                this.topics.forEach((topic) => (topic.isSelected = false))
            } else {
                this.isOpenAll = false

                {{-- const topic = this.topics.find((topic) => topic.category == topicName)
                topic.isSelected = true --}}
                this.topics.forEach((topic) => (topic.isSelected = topic.category == topicName))
            }

        }
    }">
        <div class="conn-filters max-w-[12rem]">
            <ul class="list-filter flex flex-col gap-6">
                <li class="inline-flex items-center justify-center w-full">
                    <button @click.prevent="selectFilter(openAll)" x-text="openAll" :class="isOpenAll ? 'pointer-events-none bg-blue-500 text-white' : 'bg-gray-300'" class="w-full opacity-60 text-sm font-semibold !rounded-md text-center py-2 px-3 hover:bg-blue-500 hover:text-white cursor-pointer transition duration-200"></button>
                </li>
                <template x-for="(topic, index) in topics" :key="index">
                    <li class="inline-flex items-center justify-center w-full">
                        <button @click.prevent="selectFilter(topic.category)" x-text="topic.category" :class="topic.isSelected ? 'pointer-events-none bg-blue-500 text-white' : 'bg-gray-300'" class="w-full opacity-60 text-sm font-semibold !rounded-md text-center py-2 px-3 hover:bg-blue-500 hover:text-white cursor-pointer transition duration-200"></button>
                    </li>
                </template>
            </ul>
        </div>
        <div class="conn-faqs w-full overflow-hidden break-words">
            <div class="faq-list flex flex-wrap gap-8">
                <template x-for="(faq, index) in topics" :key="index">
                    <div x-show="isOpenAll || faq.isSelected" x-data="{ openIndexes: [] }" class="faq flex-1 basis-[50rem] max-w-[60rem]  space-y-4">
                        <h2 class="text-xl font-bold" x-text="faq.category"></h2>
    
                        <template x-for="(qna, index) in faq.qna" :key="index">
                            <div class="border-b pb-2 w-full">
                                <button @click="openIndexes.includes(index) ? openIndexes = openIndexes.filter((_index) => index != _index) : openIndexes.push(index)"
                                    class="w-full text-left flex justify-between items-center py-2">
                                    <span x-text="qna.question" class="text-gray-800 font-medium"></span>
                                    <svg :class="openIndexes === index ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                                        fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="openIndexes.includes(index)" x-transition class="text-sm text-gray-600 mt-2 max-w-full break-words" x-text="qna.answer"></div>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </section>

@endsection