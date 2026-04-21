<template>
    <div class="flex items-center justify-between border-t border-gray-200 px-4 py-3 sm:px-6">
        <!-- Mobile pagination -->
        <div class="flex flex-1 justify-between sm:hidden">
            <component
                :is="isNavigable(previousUrl) ? Link : 'span'"
                v-bind="navigableBindings(previousUrl)"
                :class="mobilePrevClass"
            >Previous</component>
            <component
                :is="isNavigable(nextUrl) ? Link : 'span'"
                v-bind="navigableBindings(nextUrl)"
                :class="mobileNextClass"
            >Next</component>
        </div>

        <!-- Desktop pagination -->
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    {{ ' ' }}
                    <span class="font-medium">{{ meta.from }}</span>
                    {{ ' ' }}
                    to
                    {{ ' ' }}
                    <span class="font-medium">{{ meta.to }}</span>
                    {{ ' ' }}
                    of
                    {{ ' ' }}
                    <span class="font-medium">{{ meta.total }}</span>
                    {{ ' ' }}
                    results
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md bg-white shadow-xs" aria-label="Pagination">
                    <component
                        :is="isNavigable(link.url) ? Link : 'span'"
                        v-for="link in meta.links"
                        :key="link.label"
                        v-bind="navigableBindings(link.url)"
                        v-html="link.label"
                        :aria-current="link.active ? 'page' : undefined"
                        class="relative z-10 inline-flex items-center px-4 py-2 text-sm font-semibold"
                        :class="pageLinkClass(link)"
                    />
                </nav>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    meta: Object,
});

/** Laravel uses `null` for disabled / ellipsis; `''` is not safe for Inertia `Link` either. */
function isNavigable(url) {
    return url != null && url !== '';
}

function navigableBindings(url) {
    return isNavigable(url) ? { href: url } : { 'aria-disabled': 'true' };
}

function pageLinkClass(link) {
    if (!isNavigable(link.url)) {
        return 'cursor-default select-none text-gray-400 inset-ring inset-ring-gray-200';
    }
    return {
        'bg-indigo-600 text-white focus:z-20 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600': link.active,
        'text-gray-900 inset-ring inset-ring-gray-300 hover:bg-gray-50 focus:outline-offset-0': !link.active,
    };
}

const previousUrl = computed(() => props.meta?.links?.[0]?.url ?? null);
const nextUrl = computed(() => {
    const links = props.meta?.links;
    if (!links?.length) {
        return null;
    }
    return links[links.length - 1]?.url ?? null;
});

const mobileLinkActive = 'relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50';
const mobileLinkInactive = 'relative inline-flex cursor-default select-none items-center rounded-md border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-400';

const mobilePrevClass = computed(() => (isNavigable(previousUrl.value) ? mobileLinkActive : mobileLinkInactive));
const mobileNextClass = computed(() =>
    (isNavigable(nextUrl.value) ? `${mobileLinkActive} ml-3` : `${mobileLinkInactive} ml-3`),
);
</script>
