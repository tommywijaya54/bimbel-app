import { usePage } from "@inertiajs/inertia-react";

class CurrentUser{
    constructor () {
        this.props = usePage().props;
        this.user = this.props.auth.user;
        this.permissions = this.props.auth.permissions;
        this.roles = this.props.auth.roles;
    }

    hasPermission(prm){
        return this.permissions.includes(prm);
    }

    hasRole(rl){
        return this.roles.includes(rl);
    }
} 

export { CurrentUser }
