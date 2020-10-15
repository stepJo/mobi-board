<template>
    <div>
        <p class="text-md font-bold text-indigo-400 leading-7">
            {{ list.tl_title }}
        </p>
        <p class="leading-4 text-xs text-gray-500">
            {{ list.tl_description }}
        </p>

        <div class="flex justify-end">
            <i
                @click.prevent="showEditModal"
                class="fas fa-edit mt-1 text-lg text-orange-300 cursor-pointer block"
            ></i>

            <i
                @click.prevent="showDeleteModal"
                class="fas fa-eraser mt-1 ml-2 text-lg text-red-500 cursor-pointer block"
            ></i>
        </div>
    </div>
</template>

<script>
export default {
    props: ["list"],
    methods: {
        showEditModal() {
            this.showModal("edit-tasklist-modal");

            this.$emit("show-edit-modal", this.list);
        },
        showDeleteModal() {
            this.showModal("delete-tasklist-modal");

            this.$emit("show-delete-modal", this.list);
        }
    },
    watch: {
        list() {}
    }
};
</script>

<style></style>
