<template>
    <div>
        <loading
            :active.sync="loading"
            :opacity="0.7"
            color="blue"
            blur="5px"
        />

        <modal
            name="delete-tasklist-modal"
            :draggable="false"
            :resizable="true"
            :adaptive="true"
            :scrollable="true"
            :height="300"
        >
            <div class="flex p-3 bg-red-500">
                <h2 class="text-md text-white font-bold">
                    Delete Task List
                </h2>
            </div>
            <div class="p-3 flex flex-col align-content-between">
                <p class="my-2">
                    Title : <br />
                    <span class="text-indigo-400 font-bold">{{
                        tl_title
                    }}</span>
                </p>
                <p class="my-2">
                    Description : <br />
                    <span class="text-gray-500">{{ tl_description }}</span>
                </p>
            </div>

            <div class="w-full p-3 bg-gray-100">
                <button
                    @click.prevent="closeModal('delete-tasklist-modal')"
                    class="px-2 py-2 mr-2 text-white text-xs bg-gray-700 rounded-md shadow hover:bg-gray-900 transition duration-300 ease-in-out"
                >
                    <i class="fas fa-times" /> Cancel
                </button>

                <button
                    @click.prevent="destroy"
                    class="px-3 py-2 text-white text-xs bg-red-500 rounded shadow hover:bg-red-700 transition duration-300 ease-in-out"
                >
                    <i class="fas fa-edit" /> Delete
                </button>
            </div>
        </modal>
    </div>
</template>

<script>
export default {
    props: ["tl_id", "tl_title", "tl_description"],
    data() {
        return {
            loading: false
        };
    },
    methods: {
        destroy() {
            this.loading = true;

            axios
                .delete(`/api/task_list/${this.tl_id}/destroy`, {
                    data: { tl_id: this.tl_id }
                })
                .then(response => {
                    this.loading = false;

                    this.$emit("tasklist-deleted", response.data.task_list);
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
};
</script>

<style></style>
