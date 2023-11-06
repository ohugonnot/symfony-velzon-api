import React, {useEffect, useRef, useState} from 'react';


export default function CompaniesList(props) {

    // start bulk selection checkbox

    var checkAll = document.getElementById("checkAll");
    if (checkAll) {
        checkAll.onclick = function () {
            var checkboxes = document.querySelectorAll('.form-check-all input[type="checkbox"]');
            var checkedCount = document.querySelectorAll('.form-check-all input[type="checkbox"]:checked').length;
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = this.checked;
                if (checkboxes[i].checked) {
                    checkboxes[i].closest("tr").classList.add("table-active");
                } else {
                    checkboxes[i].closest("tr").classList.remove("table-active");
                }
            }

            (checkedCount > 0) ? document.getElementById("remove-actions").style.display = 'none' : document.getElementById("remove-actions").style.display = 'block';
        };
    }
    // end bulk selection checkbox


    // start pagination management

    var perPage = 8;
    var editlist = false;

//Table
    var options = {
        valueNames: [
            "id",
            "name",
            "category",
            "city",
            "country",
            "email",
            "phone",
        ],
        page: perPage,
        pagination: true,
        plugins: [
            ListPagination({
                left: 2,
                right: 2
            })
        ]
    };


    // end pagination management

    // const fields = [
    //     {label: 'active', type: 'boolean',}
    // ]
    const getCompanies = async () => {
        const response = await fetch('/api/companies.json');
        const data = await response.json();
        setCompanies(data);
        // Init list


    }

    const [companies, setCompanies] = useState([])

    useEffect(() => {
        getCompanies();
    }, []);

    const modalRef = useRef()
    const editBtnRef = useRef([])
    editBtnRef.current = companies.map((company, i) => editBtnRef.current[i])
    if (editBtnRef.current.length > 0) {
        console.log(editBtnRef)
    }


    //-------------------------------------------------------------------------
    var idField = document.getElementById("id-field"),
        companyNameField = document.getElementById("companyname-field"),
        companyCategoryField = document.getElementById("companycategory-field"),
        companyAdressField = document.getElementById("companyadress-field"),
        companyCityField = document.getElementById("companycity-field"),
        companyCountryField = document.getElementById("companycountry-field"),
        companyEmailField = document.getElementById("companyemail-field"),
        companyPhoneField = document.getElementById("companyphone-field"),
        companyContactsField = document.getElementById("companycontacts-field"),
        companyActiveField = document.getElementById("companyactive-field"),
        companyImgSrcField = document.getElementById("companyimgsrc-field"),

        addBtn = document.getElementById("add-btn"),
        editBtn = document.getElementById("edit-btn"),
        removeBtns = document.getElementsByClassName("remove-item-btn"),
        editBtns = document.getElementsByClassName("edit-item-btn"),
        viewBtns = document.getElementsByClassName("view-item-btn");
    // refreshCallbacks();
    let test = document.getElementById("showModal")
    if (modalRef.current) {
        modalRef.current.addEventListener("show.bs.modal", function (e) {
            if (e.relatedTarget.classList.contains("edit-item-btn")) {
                document.getElementById("exampleModalLabel").innerHTML = "Edit Company";
                document.getElementById("showModal").querySelector(".modal-footer").style.display = "block";
                document.getElementById("add-btn").innerHTML = "Update";
            } else if (e.relatedTarget.classList.contains("add-btn")) {
                document.getElementById("exampleModalLabel").innerHTML = "Add Company";
                document.getElementById("showModal").querySelector(".modal-footer").style.display = "block";
                document.getElementById("add-btn").innerHTML = "Add Company";
            } else {
                document.getElementById("exampleModalLabel").innerHTML = "List Company";
                document.getElementById("showModal").querySelector(".modal-footer").style.display = "none";
            }
        });
    }


//     ischeckboxcheck();
//
//     document.getElementById("showModal").addEventListener("hidden.bs.modal", function () {
//         clearFields();
//     });
//
//     document.querySelector("#companyList").addEventListener("click", function () {
//         ischeckboxcheck();
//     });
//
//     var table = document.getElementById("customerTable");
// // save all tr
//     var tr = table.getElementsByTagName("tr");
//     var trlist = table.querySelectorAll(".list tr");
//
//     var count = 11;
//     var forms = document.querySelectorAll('.tablelist-form')
    //-------------------------------------------------------------------------


    return <>
        <div className="col-xxl-9">
            <div className="card" id="companyList">
                <div className="card-header">
                    <div className="row g-2">
                        <div className="col-md-3">
                            <div className="search-box">
                                <input type="text" className="form-control search"
                                       placeholder="Search for company..."/>
                                <i className="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div className="col-md-auto ms-auto">
                            <div className="d-flex align-items-center gap-2">
                                <span className="text-muted">Sort by: </span>
                                <select className="form-control mb-0" data-choices
                                        data-choices-search-false id="choices-single-default">
                                    <option value={"Owner"}>Owner</option>
                                    <option value={"Company"}>Company</option>
                                    <option value={"location"}>Location</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="card-body">
                    <div>
                        <div className="table-responsive table-card mb-3">
                            <table className="table align-middle table-nowrap mb-0" id="customerTable">
                                <thead className="table-light">
                                <tr>
                                    <th scope="col" style={{width: '50px'}}>
                                        <div className="form-check">
                                            <input className="form-check-input" type="checkbox"
                                                   id="checkAll" value={"option"}/>
                                        </div>
                                    </th>
                                    <th className="sort" data-sort="name" scope="col">Nom</th>
                                    <th className="sort" data-sort="owner" scope="col">Type</th>
                                    <th className="sort" data-sort="industry_type" scope="col">Email
                                    </th>
                                    <th className="sort" data-sort="star_value" scope="col">Téléphone</th>
                                    <th className="sort" data-sort="location" scope="col">Adresse</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody className="list form-check-all">
                                {companies.map((company, i) => <tr key={company.id}>
                                    <th scope="row">
                                        <div className="form-check">
                                            <input className="form-check-input" type="checkbox"
                                                   name="chk_child" value={"option1"}/>
                                        </div>
                                    </th>
                                    <td className="id" style={{display: 'none'}}><a
                                        href=""
                                        className="fw-medium link-primary">#VZ001</a></td>
                                    <td className='name'>
                                        <div className="d-flex align-items-center">
                                            <div className="flex-shrink-0">
                                                <img src="/assets/images/companies/img-8.png" alt=""
                                                     className="avatar-xxs rounded-circle image_src object-fit-cover"/>
                                            </div>
                                            <div className="flex-grow-1 ms-2 name">
                                                <a href={company.id}>
                                                    {company.name}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td className="category">{company.category}</td>
                                    <td className="email">{company.email}</td>
                                    <td><span className="phone">{company.phone}</span> <i
                                        className="ri-star-fill text-warning align-bottom"></i></td>
                                    <td className="city">{company.city}, {company.country}</td>
                                    <td>
                                        <ul className="list-inline hstack gap-2 mb-0">
                                            <li className="list-inline-item edit"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                data-bs-placement="top" title="Call">
                                                <a href=""
                                                   className="text-muted d-inline-block">
                                                    <i className="ri-phone-line fs-16"></i>
                                                </a>
                                            </li>
                                            <li className="list-inline-item edit"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                data-bs-placement="top" title="Message">
                                                <a href=""
                                                   className="text-muted d-inline-block">
                                                    <i className="ri-question-answer-line fs-16"></i>
                                                </a>
                                            </li>
                                            <li className="list-inline-item" data-bs-toggle="tooltip"
                                                data-bs-trigger="hover" data-bs-placement="top"
                                                title="View">
                                                <a href="" className="view-item-btn"><i
                                                    className="ri-eye-fill align-bottom text-muted"></i></a>
                                            </li>
                                            <li className="list-inline-item" data-bs-toggle="tooltip"
                                                data-bs-trigger="hover" data-bs-placement="top"
                                                title="Edit">
                                                <a id={company.id} className="edit-item-btn"
                                                   href="#showModal"
                                                   data-bs-toggle="modal">blaaaaaaa<i ref={editBtnRef.current[i]}
                                                                                      className="ri-pencil-fill align-bottom text-muted"></i></a>
                                            </li>
                                            <li className="list-inline-item" data-bs-toggle="tooltip"
                                                data-bs-trigger="hover" data-bs-placement="top"
                                                title="Delete">
                                                <a className="remove-item-btn" data-bs-toggle="modal"
                                                   href="#deleteRecordModal">
                                                    <i className="ri-delete-bin-fill align-bottom text-muted"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>)}


                                </tbody>
                            </table>
                            <div className="noresult" style={{display: 'none'}}>
                                <div className="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json"
                                               trigger="loop" colors="primary:#121331,secondary:#08a88a"
                                               style={{width: '75px', height: '75px'}}></lord-icon>
                                    <h5 className="mt-2">Sorry! No Result Found</h5>
                                    <p className="text-muted mb-0">We've searched more than 150+
                                        companies We did not find any companies for you search.</p>
                                </div>
                            </div>
                        </div>
                        <div className="d-flex justify-content-end mt-3">
                            <div className="pagination-wrap hstack gap-2">
                                <a className="page-item pagination-prev disabled" href="#">
                                    Previous
                                </a>
                                <ul className="pagination listjs-pagination mb-0"></ul>
                                <a className="page-item pagination-next" href="#">
                                    Next
                                </a>
                            </div>
                        </div>
                    </div>
                    <div className="modal fade" ref={modalRef} id="showModal" tabIndex="-1"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div className="modal-dialog modal-dialog-centered modal-lg">
                            <div className="modal-content border-0">
                                <div className="modal-header bg-info-subtle p-3">
                                    <h5 className="modal-title" id="exampleModalLabel"></h5>
                                    <button type="button" className="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close" id="close-modal"></button>
                                </div>
                                <form className="tablelist-form" autoComplete="off">
                                    <div className="modal-body">
                                        <input type="hidden" id="id-field"/>
                                        <div className="row g-3">
                                            <div className="col-lg-12">
                                                <div className="text-center">
                                                    <div className="position-relative d-inline-block">
                                                        <div
                                                            className="position-absolute bottom-0 end-0">
                                                            <label htmlFor="company-logo-input"
                                                                   className="mb-0"
                                                                   data-bs-toggle="tooltip"
                                                                   data-bs-placement="right"
                                                                   title="Select Image">
                                                                <div
                                                                    className="avatar-xs cursor-pointer">
                                                                    <div
                                                                        className="avatar-title bg-light border rounded-circle text-muted">
                                                                        <i className="ri-image-fill"></i>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                            <input className="form-control d-none"
                                                                   defaultValue={""} id="company-logo-input"
                                                                   type="file"
                                                                   accept="image/png, image/gif, image/jpeg"/>
                                                        </div>
                                                        <div className="avatar-lg p-1">
                                                            <div
                                                                className="avatar-title bg-light rounded-circle">
                                                                <img
                                                                    src="/assets/images/users/multi-user.jpg"
                                                                    id="companylogo-img"
                                                                    className="avatar-md rounded-circle object-fit-cover"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h5 className="fs-13 mt-3">Company Logo</h5>
                                                </div>
                                                <div>
                                                    <label htmlFor="companyname-field"
                                                           className="form-label">Name</label>
                                                    <input type="text" id="companyname-field"
                                                           className="form-control"
                                                           placeholder="Enter company name" required/>
                                                </div>
                                            </div>
                                            <div className="col-lg-6">
                                                <div>
                                                    <label htmlFor="owner-field" className="form-label">Owner
                                                        Name</label>
                                                    <input type="text" id="owner-field"
                                                           className="form-control"
                                                           placeholder="Enter owner name" required/>
                                                </div>
                                            </div>
                                            <div className="col-lg-6">
                                                <div>
                                                    <label htmlFor="industry_type-field"
                                                           className="form-label">Industry Type</label>
                                                    <select className="form-select"
                                                            id="industry_type-field">
                                                        <option value={""}>Select industry type</option>
                                                        <option value={"Computer Industry"}>Computer
                                                            Industry
                                                        </option>
                                                        <option value={"Chemical Industries"}>Chemical
                                                            Industries
                                                        </option>
                                                        <option value={"Health Services"}>Health
                                                            Services
                                                        </option>
                                                        <option
                                                            value={"Telecommunications Services"}>Telecommunications
                                                            Services
                                                        </option>
                                                        <option
                                                            value={"Textiles: Clothing, Footwear"}>Textiles:
                                                            Clothing, Footwear
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div className="col-lg-4">
                                                <div>
                                                    <label htmlFor="star_value-field"
                                                           className="form-label">Rating</label>
                                                    <input type="text" id="star_value-field"
                                                           className="form-control"
                                                           placeholder="Enter rating" required/>
                                                </div>
                                            </div>
                                            <div className="col-lg-4">
                                                <div>
                                                    <label htmlFor="location-field"
                                                           className="form-label">Location</label>
                                                    <input type="text" id="location-field"
                                                           className="form-control"
                                                           placeholder="Enter location" required/>
                                                </div>
                                            </div>
                                            <div className="col-lg-4">
                                                <div>
                                                    <label htmlFor="employee-field"
                                                           className="form-label">Employee</label>
                                                    <input type="text" id="employee-field"
                                                           className="form-control"
                                                           placeholder="Enter employee" required/>
                                                </div>
                                            </div>
                                            <div className="col-lg-6">
                                                <div>
                                                    <label htmlFor="website-field"
                                                           className="form-label">Website</label>
                                                    <input type="text" id="website-field"
                                                           className="form-control"
                                                           placeholder="Enter website" required/>
                                                </div>
                                            </div>
                                            <div className="col-lg-6">
                                                <div>
                                                    <label htmlFor="contact_email-field"
                                                           className="form-label">Contact Email</label>
                                                    <input type="text" id="contact_email-field"
                                                           className="form-control"
                                                           placeholder="Enter contact email" required/>
                                                </div>
                                            </div>
                                            <div className="col-lg-12">
                                                <div>
                                                    <label htmlFor="since-field"
                                                           className="form-label">Since</label>
                                                    <input type="text" id="since-field"
                                                           className="form-control"
                                                           placeholder="Enter since" required/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="modal-footer">
                                        <div className="hstack gap-2 justify-content-end">
                                            <button type="button" className="btn btn-light"
                                                    data-bs-dismiss="modal">Close
                                            </button>
                                            <button type="submit" className="btn btn-success"
                                                    id="add-btn">Add Company
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div className="modal fade zoomIn" id="deleteRecordModal" tabIndex="-1"
                         aria-labelledby="deleteRecordLabel" aria-hidden="true">
                        <div className="modal-dialog modal-dialog-centered">
                            <div className="modal-content">
                                <div className="modal-header">
                                    <button type="button" className="btn-close" id="deleteRecord-close"
                                            data-bs-dismiss="modal" aria-label="Close"
                                            id="btn-close"></button>
                                </div>
                                <div className="modal-body p-5 text-center">
                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                                               trigger="loop" colors="primary:#405189,secondary:#f06548"
                                               style={{width: '90px', height: '90px'}}></lord-icon>
                                    <div className="mt-4 text-center">
                                        <h4 className="fs-semibold">You are about to delete a company
                                            ?</h4>
                                        <p className="text-muted fs-14 mb-4 pt-1">Deleting your company
                                            will remove all of your information from our database.</p>
                                        <div className="hstack gap-2 justify-content-center remove">
                                            <button
                                                className="btn btn-link link-success fw-medium text-decoration-none"
                                                data-bs-dismiss="modal">
                                                <i className="ri-close-line me-1 align-middle"></i> Close
                                            </button>
                                            <button className="btn btn-danger" id="delete-record">Yes,
                                                Delete It!!
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div className="col-xxl-3">
            <div className="card" id="company-view-detail">
                <div className="card-body text-center">
                    <div className="position-relative d-inline-block">
                        <div className="avatar-md">
                            <div className="avatar-title bg-light rounded-circle">
                                <img src="/assets/images/brands/mail_chimp.png" alt=""
                                     className="avatar-sm rounded-circle object-fit-cover"/>
                            </div>
                        </div>
                    </div>
                    <h5 className="mt-3 mb-1">Syntyce Solution</h5>
                    <p className="text-muted">Michael Morris</p>

                    <ul className="list-inline mb-0">
                        <li className="list-inline-item avatar-xs">
                            <a href=""
                               className="avatar-title bg-success-subtle text-success fs-15 rounded">
                                <i className="ri-global-line"></i>
                            </a>
                        </li>
                        <li className="list-inline-item avatar-xs">
                            <a href=""
                               className="avatar-title bg-danger-subtle text-danger fs-15 rounded">
                                <i className="ri-mail-line"></i>
                            </a>
                        </li>
                        <li className="list-inline-item avatar-xs">
                            <a href=""
                               className="avatar-title bg-warning-subtle text-warning fs-15 rounded">
                                <i className="ri-question-answer-line"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div className="card-body">
                    <h6 className="text-muted text-uppercase fw-semibold mb-3">Information</h6>
                    <p className="text-muted mb-4">A company incurs fixed and variable costs such as the
                        purchase of raw materials, salaries and overhead, as explained by
                        AccountingTools, Inc. Business owners have the discretion to determine the
                        actions.</p>
                    <div className="table-responsive table-card">
                        <table className="table table-borderless mb-0">
                            <tbody>
                            <tr>
                                <td className="fw-medium" scope="row">Industry Type</td>
                                <td>Chemical Industries</td>
                            </tr>
                            <tr>
                                <td className="fw-medium" scope="row">Location</td>
                                <td>Damascus, Syria</td>
                            </tr>
                            <tr>
                                <td className="fw-medium" scope="row">Employee</td>
                                <td>10-50</td>
                            </tr>
                            <tr>
                                <td className="fw-medium" scope="row">Rating</td>
                                <td>4.0 <i className="ri-star-fill text-warning align-bottom"></i></td>
                            </tr>
                            <tr>
                                <td className="fw-medium" scope="row">Website</td>
                                <td>
                                    <a href=""
                                       className="link-primary text-decoration-underline">www.syntycesolution.com</a>
                                </td>
                            </tr>
                            <tr>
                                <td className="fw-medium" scope="row">Contact Email</td>
                                <td>info@syntycesolution.com</td>
                            </tr>
                            <tr>
                                <td className="fw-medium" scope="row">Since</td>
                                <td>1995</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </>
}

