import { InertiaLink } from "@inertiajs/inertia-react"
import Icon from "./Icon"
import SimpleLink from "./SimpleLink";

export default ({user}) => {
    // console.log(user);
    
    return <>
        <SimpleLink
            type="user"
            href='/user'
            id={user.id}
        >
            {user.name}
        </SimpleLink>
    </>
}