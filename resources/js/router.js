import Board from "./components/task/Board.vue";

const routes = [
    {
        name: "home",
        path: "/",
        component: {
            template: "<router-view/>"
        }
    },
    {
        name: "task",
        path: "/task",
        component: Board
    }
];

export default {
    mode: "history",
    linkActiveClass: "active",
    routes
};
