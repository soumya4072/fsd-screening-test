"use client";

import { useForm } from "react-hook-form";
import api from "../../../lib/api";
import { toast } from "react-hot-toast";

export default function BookingForm({ booking }: any) {
  const { register, handleSubmit } = useForm({
    defaultValues: booking || {},
  });

  const onSubmit = async (data: any) => {
    try {
      booking
        ? await api.put(`/bookings/${booking.id}`, data)
        : await api.post("/bookings", data);

      toast.success("Booking saved");
    } catch {
      toast.error("Something went wrong");
    }
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)} className="space-y-4">
      <input {...register("email")} placeholder="Email" className="input" />
      <input {...register("booking_date")} type="datetime-local" />
      <button className="btn">Save</button>
    </form>
  );
}