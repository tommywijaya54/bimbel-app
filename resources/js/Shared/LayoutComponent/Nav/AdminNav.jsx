import { Link, usePage } from "@inertiajs/inertia-react";
import Nav from "./Nav";

export default () => {
    return (
    <nav className="bg-slate-100 border-b border-gray-100 admin-nav">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="flex h-10">   
                <div className="grow hidden space-x-8  sm:flex">
                    <Nav route_name='registration' />
                    <Nav route_name='student' />
                    <Nav route_name='parent' />
                    <Nav route_name='school' />

                    <Nav route_name='promolist' />
                    <Nav route_name='pricelist' />
                </div>
                <div className="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <Nav route_name='branch' />
                    <Nav route_name='employee' />
                    
                    <Nav route_name='role'>Role & Permission</Nav>
                    <Nav route_name='user'>All User</Nav>
                </div>
                

            </div>
        </div>
    </nav>)
}