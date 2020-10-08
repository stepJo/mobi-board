<template>
    <div>
        <ul class="nav">
            <li :class="{ active: $route.path == '/' }" class="nav-item">
                <router-link to="/">
                    <i class="fas fa-home"></i>

                    <p>Home</p>

                    <span class="badge badge-count">5</span>
                </router-link>
            </li>

            <li :class="{ active: $route.path == '/task' }" class="nav-item">
                <router-link to="/task">
                    <i class="fas fa-tasks"></i>

                    <p>Task</p>
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
export default {};
</script>
