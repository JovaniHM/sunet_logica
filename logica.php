<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lógicas Sunet</title>

    <!-- Bootstratp -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- VueJS -->
    <!-- <script src="https://unpkg.com/vue@3.2.26/dist/vue.global.prod.js"></script> -->
    <script src="https://unpkg.com/vue@3"></script>
</head>

<body>
    <div class="container py-4" id="app">
        <h4 class="text-center mb-5">Lógica de Preguntas</h4>

        <div v-if="!configurarLogica" class="col-12 d-flex justify-content-center">
            <div class="col-md-7 text-center">
                <p>No se ha generado una lógica de preguntas para este formulario, comienza agregando una a continuación.</p>
                <label for="chbConfigurarLogica" class="btn btn-success btn-lg rounded-pill shadow-none">
                    <i class="bi bi-gear-fill"></i>
                    Configurar Lógica
                </label>
                <input type="checkbox" class="d-none" id="chbConfigurarLogica" v-model="configurarLogica">
            </div>
        </div>

        <div v-else class="col-12">
            <div class="text-center mb-3">
                <span class="bg-light py-2 px-4 rounded-pill">
                    Formulario: <strong>{{ nombreFormulario }}</strong>
                </span>
                <br><br>
                <span>{{ descripcionFormulario }}</span>
            </div>
            <div v-for="(logica, i) in logicasConfiguradas" class="card shadow border-0 mb-2">
                <div class="card-header bg-white d-flex algn-items-center">
                    <button class="btn shadow-none flex-grow-1 text-start" type="button" data-bs-toggle="collapse" :data-bs-target="`#collapseLogic${ i }`">
                        <i class="bi bi-list-ol me-3"></i>
                        Lógica {{ i + 1 }}
                    </button>
                    <button @click="eliminarLogica( i )" class="btn btn-sm rounded-pill shadow-sm mx-2">
                        <i class="bi bi-trash2-fill me-2"></i>
                        Eliminar Lógica
                    </button>
                </div>
                <div class="collapse" :id="`collapseLogic${ i }`">
                    <div class="card-body">
                        <div v-for="(condicion, j) in logica.condiciones">
                            <div class="d-flex mb-2">
                                <button v-if="j !== 0" @click="eliminarCondicion( i, j )" class="btn shadow-none">
                                    <i class="bi bi-trash2-fill"></i>
                                </button>
                                <button v-else class="btn shadow-none">
                                    <i class="bi bi-trash2-fill text-white"></i>
                                </button>
                                <select @change="asignarRespuestasPregunta( i, j, condicion.preguntaId )" class="form-select shadow-none ms-2" v-model="condicion.preguntaId">
                                    <option value="0" disabled>- Seleccione una pregunta -</option>
                                    <option v-for="pregunta in preguntasLogic" :value="pregunta.id">
                                        {{ `${ pregunta.posicion }.- ${ pregunta.titulo }` }}
                                    </option>
                                </select>
                                <select class="form-select shadow-none ms-2" v-model="condicion.respuesta">
                                    <option value="" disabled>- Seleccione una respuesta -</option>
                                    <option v-for="respuesta in condicion.respuestas" :value="respuesta">
                                        {{ respuesta }}
                                    </option>
                                </select>
                                <select class="form-select shadow-none ms-2" v-model="condicion.seleccionada">
                                    <option value="1">Seleccionada</option>
                                </select>
                            </div>
                            <div v-if="j < logica.condiciones.length - 1" class="text-center mb-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" :name="`rdCondicion${ i }${ j }`" :id="`rdbOr${ i }${ j }`" value="||" v-model="condicion.condicion">
                                    <label class="form-check-label" :for="`rdbOr${ i }${ j }`">OR</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" :name="`rdCondicion${ i }${ j }`" :id="`rdbAnd${ i }${ j }`" value="&" v-model="condicion.condicion">
                                    <label class="form-check-label" :for="`rdbAnd${ i }${ j }`">AND</label>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <button @click="agregarCondicion( i )" class="btn btn-sm btn-success rounded-pill shadow-sm mx-2">
                                <i class="bi bi-plus-circle-fill me-2"></i>
                                Agregar Condición
                            </button>
                        </div>
                        <hr>
                        <div class="row px-2">
                            <div class="col-6 d-flex pt-1">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" :name="`rdbTypo${ i }`" :id="`rdbOcultar${ i }`" value="hide" v-model="logica.acction">
                                    <label class="form-check-label" :for="`rdbOcultar${ i }`">Ocultar</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" :name="`rdbTypo${ i }`" :id="`rdbMostrar${ i }`" value="show" v-model="logica.acction">
                                    <label class="form-check-label" :for="`rdbMostrar${ i }`">Mostrar</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" :name="`rdbTypo${ i }`" :id="`rdbSaltar${ i }`" value="go" v-model="logica.acction">
                                    <label class="form-check-label" :for="`rdbSaltar${ i }`">Saltar</label>
                                </div>
                            </div>
                            <div class="col-6 text-center">
                                <div v-for="(id, j) in logica.preguntaAfectadaId" :key="id" class="d-flex align-items-center ms-2 mb-2">
                                    <button v-if="j !== 0" @click="eliminarPreguntaAfectada( i, j )" class="btn btn-sm shadow-sm text-center rounded-pill">
                                        <i class="bi bi-trash2-fill"></i>
                                    </button>
                                    <button v-else class="btn btn-sm text-white">
                                        <i class="bi bi-trash2-fill"></i>
                                    </button>

                                    <select class="form-select shadow-none ms-2" v-model="logica.preguntaAfectadaId[j]">
                                        <option value="0" disabled>- Seleccione una pregunta -</option>
                                        <option v-for="pregunta in preguntasAfecadas" :value="pregunta.id" :disabled="logica.preguntaAfectadaId.some(pId => pId == pregunta.id)">
                                            {{ `${ pregunta.posicion }.- ${ pregunta.titulo }` }}
                                        </option>
                                    </select>
                                </div>

                                <button @click="agregarPreguntaAfectada( i )" class="btn btn-sm btn-success shadow-sm rounded-pill text-center">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <button @click="agregarLogica" class="btn btn-success rounded-pill shadow mx-1">
                    <i class="bi bi-plus-circle-fill me-2"></i>
                    Agregar Lógica
                </button>
                <button @click="guardarLogicasConfiguradas" class="btn rounded-pill shadow mx-1">
                    <span v-if="isFetching">
                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                        Guardando lógica...
                    </span>
                    <span v-else>
                        <i class="bi bi-check-lg me-2"></i>
                        Guardar Configuración
                    </span>
                </button>
            </div>
        </div>
    </div>

    <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body rounded" id="toastBody">
            </div>
        </div>
    </div>

    <script>
        (() => {
            const wsSunet = 'http://3.12.28.29/sunet_ws';
            const toast = new bootstrap.Toast(document.querySelector('#liveToast'));
            const toastBody = document.querySelector('#toastBody');

            const idForm = localStorage.getItem('formulario_id');

            const condicionesData = {
                formLogicId: 0,
                preguntaId: 0,
                respuesta: '',
                seleccionada: 1,
                condicion: '',
                respuestas: []
            }

            const logicaData = {
                condiciones: [],
                acction: 'hide',
                preguntaAfectadaId: [],
                grupo: 0,
            }

            Vue.createApp({
                data() {
                    return {
                        nombreFormulario: '',
                        descripcionFormulario: '',
                        configurarLogica: false,
                        logicasConfiguradas: [],
                        logicasBorradas: [],
                        preguntasLogic: [],
                        preguntasAfecadas: [],
                        isFetching: false,
                    }
                },
                methods: {
                    async obtenerPreguntas() {
                        const getFormInfo = new Promise((resolve, reject) => {
                            fetch(`${ wsSunet }/getFormInfo/${ idForm }`).then( resp => resp.json() )
                            .then( resolve ).catch( reject );
                        });

                        const getCampos = new Promise((resolve, reject) => {
                            fetch(`${ wsSunet }/getFieldsForm/${ idForm }`).then( resp => resp.json() )
                            .then( resolve ).catch( reject );
                        });

                        const getLogic = new Promise((resolve, reject) => {
                            fetch(`${ wsSunet }/getLogicFields/${ idForm }`).then( resp => resp.json() )
                            .then( resolve ).catch( reject );
                        });

                        const [ formInfo, campos, Logic ] = await Promise.all([ getFormInfo, getCampos, getLogic ]);

                        this.nombreFormulario = formInfo.data[ 0 ].titulo;
                        this.descripcionFormulario = formInfo.data[ 0 ].introduccion;
                        this.preguntasLogic = campos.data.filter(({ tipo }) => tipo === 'check' || tipo === 'radio' || tipo === 'select');
                        // this.preguntasAfecadas = campos.data.filter(({ tipo }) => tipo !== 'check' && tipo !== 'radio' && tipo !== 'select');
                        this.preguntasAfecadas = campos.data;

                        if ( Logic.data.length !== 0 ) {
                            this.configurarLogica = true;

                            const mainGrupos = [ ...new Set( Logic.data.map(({ MAIN_GRUPO }) => MAIN_GRUPO ) ) ];

                            mainGrupos.forEach((mainGrupo, i) => {
                                const gruposByMainGrupo = Logic.data.filter(({ MAIN_GRUPO }) => MAIN_GRUPO == mainGrupo);
                                const idPreguntasAfectafas = [ ...new Set( gruposByMainGrupo.map(({ ID_QUESTION }) => ID_QUESTION) ) ];

                                const index = this.logicasConfiguradas.push({
                                    condiciones: [],
                                    acction: gruposByMainGrupo[ 0 ].ACTION,
                                    preguntaAfectadaId: idPreguntasAfectafas,
                                    grupo: gruposByMainGrupo[ 0 ].GRUPO
                                }) - 1;

                                const grupos = [ ...new Set( gruposByMainGrupo.map(({ GRUPO }) => GRUPO ) ) ];
                                const onlyGrupos = gruposByMainGrupo.filter(({ GRUPO }) => GRUPO == grupos[0] );

                                onlyGrupos.forEach(({ ID_FORM_LOGIC, ID_FIELD, ANSWER, CONDITION }, j) => {
                                    this.logicasConfiguradas[ index ].condiciones.push({
                                        formLogicId: ID_FORM_LOGIC,
                                        preguntaId: ID_FIELD,
                                        respuesta: ANSWER,
                                        seleccionada: 1,
                                        condicion: CONDITION,
                                        respuestas: []
                                    });

                                    this.asignarRespuestasPregunta( i, j, ID_FIELD, false );
                                });
                            });
                        }

                        console.log( this.logicasConfiguradas )
                    },
                    agregarLogica() {
                        if ( this.isFetching ) return;

                        this.logicasConfiguradas.push({
                            ...logicaData,
                            condiciones: [{
                                ...condicionesData
                            }],
                            preguntaAfectadaId: [ 0 ],
                            grupo: this.logicasConfiguradas.length
                        });
                    },
                    eliminarLogica(i) {
                        if ( this.isFetching ) return;

                        this.logicasConfiguradas[ i ].condiciones.forEach(({ formLogicId }) => {
                            if ( formLogicId != 0 ) this.logicasBorradas.push( formLogicId );
                        })

                        this.logicasConfiguradas = this.logicasConfiguradas.filter((v, index) => index !== i);
                    },
                    agregarCondicion(i) {
                        if ( this.isFetching ) return;

                        this.logicasConfiguradas[i].condiciones.push({
                            ...condicionesData
                        });
                    },
                    eliminarCondicion(i, j) {
                        if ( this.isFetching ) return;

                        const idCondition = this.logicasConfiguradas[ i ].condiciones[ j ].formLogicId;

                        if ( idCondition != 0 ) this.logicasBorradas.push( idCondition );

                        this.logicasConfiguradas[i].condiciones = this.logicasConfiguradas[i].condiciones.filter((v, index) => index !== j);

                        const lingitud = this.logicasConfiguradas[i].condiciones.length - 1;

                        this.logicasConfiguradas[i].condiciones[lingitud].condicion = '';
                    },
                    asignarRespuestasPregunta(i, j, idPregunta, vaciar = true) {
                        if ( this.isFetching ) return;

                        let respuestasCadena = this.preguntasLogic.find(({ id }) => id == idPregunta).valores;
                        respuestasCadena = respuestasCadena.replace(/\r/g, '');

                        this.logicasConfiguradas[i].condiciones[j].respuestas = respuestasCadena.split(/\n/g);
                        vaciar && ( this.logicasConfiguradas[i].condiciones[j].respuesta = '' );
                    },
                    agregarPreguntaAfectada( i ) {
                        this.logicasConfiguradas[i].preguntaAfectadaId.push( 0 );
                    },
                    eliminarPreguntaAfectada( i, j ) {
                        this.logicasConfiguradas[i].preguntaAfectadaId = this.logicasConfiguradas[i].preguntaAfectadaId.filter((p, k) => k !== j);
                    },
                    guardarLogicasConfiguradas() {
                        if ( this.isFetching ) return;

                        let isLogicComplete = true;

                        this.logicasConfiguradas.forEach(({ preguntaAfectadaId, condiciones }) => {
                            if (preguntaAfectadaId == 0) isLogicComplete = false;

                            condiciones.forEach(({ preguntaId, respuesta, condicion }, j) => {
                                if (preguntaId == 0 || respuesta == '') isLogicComplete = false;
                                if (j < condiciones.length - 1 && condicion == '') isLogicComplete = false;
                            });
                        });

                        if (!isLogicComplete) {
                            toastBody.classList.remove('text-white');
                            toastBody.classList.add('bg-warning');
                            toastBody.innerHTML = `<h6 class="mb-0">Faltan datos por configurar en su lógica de preguntas. Por favor, verifique que todos los campos estén llenos.</h6>`;
                            toast.show();
                            return;
                        }

                        this.isFetching = true;

                        const config = {
                            method: 'POST',
                            body: JSON.stringify({
                                formulario_id: localStorage.formulario_id,
                                logicasConfiguradas: this.logicasConfiguradas
                            })
                        }

                        fetch(`${ wsSunet }/saveLogicFields`, config)
                        .then( resp => resp.json() )
                        .then( data => {
                            this.isFetching = false;
                            toastBody.classList.remove('bg-warning');
                            toastBody.classList.add('bg-success');
                            toastBody.classList.add('text-white');
                            toastBody.innerHTML = `<h6 class="mb-0">Lógica guardada con éxito.</h6>`;
                            toast.show()

                            // setTimeout(() => {
                            //     location.reload();
                            // }, 1750);
                        })
                        .catch( err => {
                            this.isFetching = true;
                            console.log( err );
                        })
                    }
                },
                created() {
                    this.obtenerPreguntas();
                },
            }).mount('#app');
        })();
    </script>
</body>

</html>