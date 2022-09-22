import { usePage } from '@inertiajs/inertia-react';
import ArrayList from "./ArrayList";

export default () => {
    const data = usePage().props;
    const user =  data.auth;
    const permissions = user.permissions;
    const roles = user.roles;

    return <>
        <div className="py-12">
            <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div className="bg-indigo-200 overflow-hidden shadow-sm sm:rounded-lg">
                    <div className="debug p-6">
                        <ArrayList list={permissions}></ArrayList>
                        <ArrayList list={roles}></ArrayList>
                    </div>
                </div>
            </div>
        </div>
    </>;
}