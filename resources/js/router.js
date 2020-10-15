import Board from "./components/task/Board.vue";
import LoginForm from "./components/auth/LoginForm.vue";

const routes = [
    {
        name: "login",
        path: "/login",
        component: LoginForm
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
