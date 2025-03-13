try {
    document.getElementById('formAuthentication').addEventListener("submit", async (e) => {
        e.preventDefault();
        let el = e.target;

        const formdata = new FormData(document.getElementById('formAuthentication'));
        const requestOptions = {
            method: "POST",
            body: formdata,
            redirect: "follow"
        };

        const postLogin = await fetch("/api/v1/login", requestOptions);
        let result = await postLogin.json();
        if (result.message) {
            // setCookie('token', result.token, 3600);
            Cookies.set('token', result.token, { expires: 1 });
            toastMixin.fire({
                animation: true,
                title: result.message,
                timer: 2000,
            });

            setTimeout(() => {
                location.assign("/admin/dashboard");
            }, 2000);


            return true;
        }
    });
} catch (error) {
    console.error(error)
}