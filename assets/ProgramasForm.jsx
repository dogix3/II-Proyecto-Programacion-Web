var Form = Reactstrap.Form;
var Button = Reactstrap.Button;
var FormGroup = Reactstrap.FormGroup;
var Label = Reactstrap.Label;
var Input = Reactstrap.Input;
var FormText = Reactstrap.FormText;

 class ProgramasForm extends React.Component {

    constructor(props) {

       super(props)

    this.state = {id:"",nombre_compuesto:"",num_version:"",fecha_publicacion:"",lenguaje:"", descripcion:"", id_usuario:""}

    this.handleInsert = this.handleInsert.bind(this);

    this.handleUpdate = this.handleUpdate.bind(this);

    this.handleDelete = this.handleDelete.bind(this);

    this.handleFields = this.handleFields.bind(this);

    }

    componentWillReceiveProps(nextProps) {

       this.setState({id:nextProps.programa.id});

       this.setState({nombre_compuesto:nextProps.programa.nombre_compuesto});

       this.setState({num_version:nextProps.programa.num_version});

       this.setState({fecha_publicacion:nextProps.programa.fecha_publicacion});

       this.setState({lenguaje:nextProps.programa.lenguaje});

       this.setState({descripcion:nextProps.programa.descripcion});

       this.setState({id_usuario:nextProps.programa.id_usuario});

    }

    handleInsert() {

        fetch("./server/index.php/programa/"+this.state.id,{

            method: "post",

            headers: {'Content-Type': 'application/json',

                               'Content-Length': 200},

            body: JSON.stringify({

                method: 'put',

                nombre_compuesto: this.state.nombre_compuesto,

                num_version: this.state.num_version,

                fecha_publicacion: this.state.fecha_publicacion,

                lenguaje: this.state.lenguaje,

                descripcion: this.state.descripcion,

                id_usuario: this.state.id_usuario

                       })

    }).then((response) => {

           this.props.handleChangeData();

         }

    );

    }

    handleUpdate() {

        fetch("./server/index.php/programa/"+this.state.id,{

            method: "post",

            headers: {'Content-Type': 'application/json'},

            body: JSON.stringify({

                nombre_compuesto: this.state.nombre_compuesto,

                num_version: this.state.num_version,

                fecha_publicacion: this.state.fecha_publicacion,

                lenguaje: this.state.lenguaje,

                descripcion: this.state.descripcion,

                id_usuario: this.state.id_usuario

                       })

     }).then((response) => {

           this.props.handleChangeData();

         }

    );

    }

    handleDelete() {

      fetch("./server/index.php/revision/"+this.state.id,{

            method: "post",

            headers: {'Content-Type': 'application/json'},

            body: JSON.stringify({ method: 'deleteAll'})

        }).then((response) => {

           this.props.handleChangeData();

         }

      );

        fetch("./server/index.php/programa/"+this.state.id,{

            method: "post",

            headers: {'Content-Type': 'application/json'},

            body: JSON.stringify({ method: 'delete'})

        }).then((response) => {

           this.props.handleChangeData();

         }

    );

    }

    handleFields(event) {

     const target = event.target;

     const value = target.value;

     const name = target.name;

     this.setState({[name]: value});

  }

    render() {
      if (this.props.usuario.tipo_usuario=='Programador') {
        return(<Form><table><tbody>

           <tr><td width="30%"><Label>Nombre:</Label></td>

               <td width="20%"><Input type="text" name="nombre_compuesto"

                   value={this.state.nombre_compuesto} onChange={this.handleFields}/></td></tr>

           <tr><td><Label>Numero de versión:</Label></td>

               <td><Input type="text" name="num_version"

                   value={this.state.num_version} onChange={this.handleFields}/></td></tr>

            <tr><td><Label>Fecha publicación:</Label></td>

                <td><Input type="date" name="fecha_publicacion"

                    value={this.state.fecha_publicacion} onChange={this.handleFields}/></td></tr>

           <tr><td><Label>Lenguajes:</Label></td>

               <td><Input type="text" name="lenguaje"

                   value={this.state.lenguaje} onChange={this.handleFields}/></td></tr>

           <tr><td><Label>Descripción:</Label></td>

               <td><Input type="text" name="descripcion"

                   value={this.state.descripcion} onChange={this.handleFields}/></td></tr>

            <tr><td><Label>Programadors:</Label></td>

                <td><Input type="text" name="id_usuario"

                    value={this.state.id_usuario} onChange={this.handleFields}/></td></tr>

           </tbody></table><Input type="hidden" name="id" value={this.state.id}/>

           <Table><tbody><tr>

               <td><Button onClick={this.handleInsert}>Agregar</Button></td>

               <td><Button onClick={this.handleUpdate}>Modificar</Button></td>

               <td><Button onClick={this.handleDelete}>Eliminar</Button></td>

           </tr></tbody></Table></Form>)
        }else{
          return ''
        }
    }

}