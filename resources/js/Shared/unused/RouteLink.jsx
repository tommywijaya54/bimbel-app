import { InertiaLink } from "@inertiajs/inertia-react"

export default ({ob, routename}) => {
    return <>
        <InertiaLink
            tabIndex="-1"
            // href={route(routename, ob.id)}
            className="link"
        >
            {ob.name}
        </InertiaLink>
    </>
}