<template>
    <div>
        <v-app>
            <v-navigation-drawer app v-model="drawer" :width="220">
                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title class="title">
                            <v-img
                                src="../img/nuevologo-radical.png"
                                alt="Logo"
                            ></v-img>
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list dense shaped>
                    <div v-for="item in items" :key="item.title">
                        <v-list-item
                            v-if="!item.subLinks"
                            link
                            :to="item.link"
                            color="orange darken-4"
                        >
                            <v-list-item-icon>
                                <v-icon>{{ item.icon }}</v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                                <v-list-item-title>{{
                                    item.title
                                }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-group
                            v-else-if="item.subLinks"
                            :key="item.title"
                            no-action
                            :prepend-icon="item.icon"
                            color="orange darken-4"
                        >
                            <template v-slot:activator>
                                <v-list-item-title>{{
                                    item.title
                                }}</v-list-item-title>
                            </template>
                            <v-list-item
                                v-for="sublink in item.subLinks"
                                :key="sublink.title"
                                link
                                :to="sublink.link"
                            >
                                <v-list-item-title>
                                    {{ sublink.title }}</v-list-item-title
                                >
                                <v-list-item-icon>
                                    <v-icon v-text="sublink.icon"></v-icon>
                                </v-list-item-icon>
                            </v-list-item>
                        </v-list-group>
                    </div>
                </v-list>

                <!-- <template v-slot:append>
                <div class="pa-2">
                <v-btn block dense dark @click="logout">
                    Salir
                </v-btn>
                </div>
            </template> -->
            </v-navigation-drawer>

            <v-app-bar app absolute dense dark class="grey darken-4">
                <v-app-bar-nav-icon
                    @click="drawer = !drawer"
                ></v-app-bar-nav-icon>

                <v-spacer></v-spacer>

                <v-menu left bottom>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn icon v-bind="attrs" v-on="on">
                            <v-icon>mdi-dots-vertical</v-icon>
                        </v-btn>
                    </template>

                    <v-list dense>
                        <v-subheader>{{ $store.state.user.name }}</v-subheader>
                        <v-spacer></v-spacer>
                        <v-list-item-group>
                            <v-list-item
                                @click="
                                    dialog = true;
                                    form = {};
                                "
                            >
                                <v-list-item-title>
                                    <v-icon small>mdi-lock</v-icon>
                                    Cambiar contraseña
                                </v-list-item-title>
                            </v-list-item>
                            <v-list-item @click="logout">
                                <v-list-item-title>
                                    <v-icon small>mdi-logout</v-icon>
                                    Salir
                                </v-list-item-title>
                            </v-list-item>
                        </v-list-item-group>
                    </v-list>
                </v-menu>
            </v-app-bar>

            <!-- Sizes your content based upon application components -->
            <v-main>
                <!-- Provides the application the proper gutter -->
                <v-container fluid>
                    <!-- If using vue-router -->
                    <router-view></router-view>
                </v-container>
            </v-main>
            <v-footer dense app fixed flat padless class="grey darken-4" dark>
                <v-col cols="4" class="text-left">
                    <router-link to="/"> Acerca de</router-link>
                </v-col>
                <v-col class="text-center" cols="4"
                    ><a href="https://www.gruporadical.com/" target="_blank"
                        >Grupo Radical</a
                    >
                    &copy;{{ new Date().getFullYear() }}. Todos los derechos
                    reservados
                </v-col>
                <v-col class="text-end" cols="4">Version 1.0 </v-col>
            </v-footer>
        </v-app>
        <template>
            <v-row justify="center">
                <v-dialog
                    v-model="dialog"
                    persistent
                    max-width="400px"
                    :loading="loading"
                >
                    <v-form ref="form" v-model="valid" lazy-validation>
                        <v-card>
                            <v-card-title>
                                <span class="headline"
                                    >Cambio de contraseña</span
                                >
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-alert
                                        v-if="has_error"
                                        color="red"
                                        type="error"
                                        >{{ error }}</v-alert
                                    >
                                    <v-row>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="form.old_password"
                                                label="Contraseña actual*"
                                                required
                                                type="password"
                                                :rules="[passwordRules2]"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="form.new_password"
                                                label="Nueva contraseña*"
                                                required
                                                type="password"
                                                :rules="[passwordRules2]"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="form.new_password2"
                                                label="Repita la contraseña*"
                                                required
                                                type="password"
                                                :rules="[
                                                    form.new_password ===
                                                        form.new_password2 ||
                                                        'Las claves no coinciden'
                                                ]"
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                </v-container>
                                <small>*indicates required field</small>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="red" text @click="dialog = false">
                                    Cerrar
                                </v-btn>
                                <v-btn color="blue" text @click="updateClave">
                                    Actualizar
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-form>
                </v-dialog>
            </v-row>
        </template>
    </div>
</template>
<script>
export default {
    data() {
        return {
            dialog: false,
            drawer: true,
            form: {
                old_password: null,
                new_password: null,
                new_password2: null
            },
            error: null,
            has_error: false,
            loading: false,
            valid: true,
            passwordRules1: [v => !!v || "Password old is required"],
            passwordRules2: [v => !!v || "Password new is required"],
            passwordRules3: [v => !!v || "Password repeat is required"],
            items: [
                {
                    title: "Actividades",
                    link: "/actividad",
                    icon: "mdi-table-search"
                },
                {
                    title: "Reportes",
                    icon: "mdi-chart-bar",
                    subLinks: [
                        // { title: "General", link: "/reporte-general", icon: "mdi-certificate"},
                        {
                            title: "Resumen",
                            link: "/reporte-resumen",
                            icon: "mdi-list"
                        },
                    ]
                },
                {
                    title: "Configuracion",
                    icon: "mdi-cogs",
                    subLinks: [
                        {
                            title: "Usuarios",
                            link: "/usuarios",
                            icon: "mdi-account-multiple"
                        },
                        { title: "Paises", link: "/paises", icon: "mdi-earth" },
                        {
                            title: "Certificaciones",
                            link: "/certificaciones",
                            icon: "mdi-certificate"
                        },
                        {
                            title: "Niveles",
                            link: "/nivel-estudio",
                            icon: "mdi-graph-outline"
                        }
                    ]
                }
            ],
            right: null
        };
    },
    methods: {
        logout() {
            this.$swal
                .fire({
                    title: "Esta seguro?",
                    html: `Finalizará su sesión`,
                    icon: "question",
                    showConfirmButton: true,
                    showCancelButton: true
                })
                .then(res => {
                    if (res.value) {
                        this.$store
                            .dispatch("logout")
                            .then(() => {
                                this.$router.push({ name: "login" });
                            })
                            .catch(() => []);
                        //this.$router.replace("/login");
                    }
                });
        },
        updateClave() {
            if (this.$refs.form.validate()) {
                this.form.user = this.$store.state.user.id;
                console.log(this.form);
                this.loading = true;
                this.axios
                    .post("/api/usuario-updatePassword", this.form)
                    .then(response => {
                        console.log(response);
                        if (response.data === "password error!") {
                            this.has_error = true;
                            this.error = "La contraseña anterior no coincide!";
                        } else {
                            this.dialog = false;
                            this.loading = false;
                            this.$store.dispatch("logout").then(() => {
                                this.$router.replace("/login");
                            });
                        }
                    })
                    .catch(err => console.log(err))
                    .finally(() => (this.loading = false));
            }
        }
    }
};
</script>
